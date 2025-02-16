<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        "code",
        "type",
        "value",
        "expire_date",
        "user_id",
        'subscription_ids',
        'max_usage',
        'max_usage_per_user',
    ];

    protected $casts = [
        "expire_date" => "date",
        'subscription_ids' => 'array',
    ];
    public function subscriptionsName()
    {
        $subscriptions = $this->subscription_ids;
        if(empty($subscriptions))
        {
            return null;
        }
        $names = [];
        foreach ($subscriptions as $subscription) {
            $names[] = Subscription::find($subscription)?->name;
        }
        return implode(', ', $names);

    }
    public function toggle()
    {
        $this->is_active = !$this->is_active;
        $this->save();
    }

    public static function findByCode($code , $subscriptionId)
    {
        // check for max usage per user
        // check for max usage
        $coupons = static::where('code', $code)->whereJsonContains('subscription_ids', (string) $subscriptionId)
            ->where('is_active', true)->where(function ($query) {
                $query->where('expire_date', '>', now())
                    ->orWhereNull('expire_date');
            });
        $coupon = $coupons->first();
        if (!$coupon) {
            return null;
        }
        return $coupons
            ->where(function ($query) use ($coupon) {
                $query->whereNull('max_usage')
                    ->orWhere(function ($query) use ($coupon) {
                        $query->where('max_usage', '>', $coupon->users()->count());
                    })
                ;
            })
            ->where(function ($query) use ($coupon) {
                $query->whereNull('max_usage_per_user')
                    ->orWhere(function ($query) use ($coupon) {
                        $query->where('max_usage_per_user', '>', $coupon->users()->where('user_id', auth()->id())->count());
                    });
            })
            ->first();
    }

    public function discount($total)
    {
        if ($this->type == "fixed") {
            return $this->value;
        } else {
            return ($this->value / 100) * $total;
        }
    }

    public function new_price($total)
    {
        $new_price = $total - $this->discount($total);
        if ($new_price < 0) {
            $new_price = 0;
        }
        return $new_price;
    }

    public function getExpireDateForHumanAttribute()
    {
        return $this->expire_date?->format('Y-m-d');
    }

    public function isExpired()
    {
        return $this->expire_date < now();
    }

    public function isValid()
    {
        return !$this->isExpired();
    }

    public function burn(User $user = null): void
    {
        $user = $user ?? auth()->user();
        $this->users()->attach($user->id, ['subscription_id' => request('subscription_id')]);
    }

    public function user_used()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'coupon_user', 'coupon_id', 'user_id')
            ->withPivot('subscription_id')->withTimestamps();
    }

//    public function is_used_by_user($user_id)
//    {
//        return $this->users()->where('user_id',$user_id)->exists();
//    }
}
