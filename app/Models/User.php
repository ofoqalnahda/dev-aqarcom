<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Scopes\BlockedAdScope;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $with = ['city','subscription','supportService'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function bankCalcs()
    {
        return $this->hasMany(BankCalc::class , 'user_id');
    }

    public function subscription(){
        return $this->belongsToMany(Subscription::class , 'user_subscription' , 'user_id' , 'subscription_id')->withPivot([
            'id',
            'price',
            'regular_ads','linkedin',
            'special_ads','website',
            'about'	,'gallery',
            'city_id','location',
            'lng','lat',
            'facebook','instagram',
            'is_active', 'twitter',
            'snapchat','end_date',
            'created_at' , 'updated_at',
            'facebook_status',
            'instagram_status',
            'twitter_status',
            'snapchat_status',
            'website_status',
            'linkedin_status'
        ]);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class , 'payment_id');
    }

    public function ads(){
        return $this->hasMany(Ad::class , 'user_id');
    }
    public function supportAds()
    {
        return $this->hasMany(SupportServiceAd::class , 'user_id');
    }

    public function favourite()
    {
        return $this->belongsToMany(Ad::class , 'user_favourite_ads' , 'user_id' , 'ad_id');
    }

    public function accountType()
    {
        return $this->belongsTo(AccountType::class , 'account_type_id');
    }

    public function blockedUsers()
    {
        return $this->belongsToMany(User::class , 'blocked_users','user_id' ,'blocked_id');
    }

    public function followers()
    {
        return $this->belongsToMany(self::class , 'followers' , 'user_id' , 'follower_id');
    }

//    public function isFollowed()
//    {
//        return $this->belongsToMany(self::class , 'followers' , 'follower_id' , 'user_id')->wherePivot('follower_id' , auth('api')->id());
//    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'user_service')
        ->withPivot(['city_id']);
      }
      public function servicesCity(){
        return $this->belongsToMany(City::class, 'user_service')
        ->withPivot(['service_id']);
      }

    public function supportService(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserSupportService::class);
    }

    public function supportServiceAds()
    {
        return $this->hasMany(SupportServiceAd::class);
    }


    public function city()
    {
        return $this->belongsTo(City::class , 'city_id');
    }

    public function usedCoupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_user', 'user_id', 'coupon_id');
    }

    public function scopeWithOutBlocked(Builder $query)
    {
        return $query->when(auth('api')->check() , function ($query){
            $ids = auth('api')->user()->blockedUsers()->pluck('id')->toArray();
            array_push($ids , auth('api')->id());
            return $query->whereNotIn('users.id' ,$ids);
        });
    }
}
