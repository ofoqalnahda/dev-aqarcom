<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Subscription extends Model
{
    use HasFactory ,Translatable ;
    protected $guarded = [];
    public array $translatedAttributes = ['name' , 'description'];

//    protected $with = ['translation'];

    public function users(){
        return $this->belongsToMany(User::class , 'user_subscription' , 'subscription_id' , 'user_id')->withPivot([
            'id',
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


    protected static function boot()
    {
        parent::boot();

        $model_name = class_basename(self::class);

        static::created(function ()use ($model_name) {
            cache()->forget($model_name);
        });

        static::updated(function ()use ($model_name) {
            cache()->forget($model_name);
        });

        static::deleted(function ()use ($model_name) {
            cache()->forget($model_name);
        });
    }
}
