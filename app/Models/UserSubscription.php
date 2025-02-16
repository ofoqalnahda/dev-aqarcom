<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;
    protected $table = 'user_subscription';
    protected $guarded = [];

    protected $casts = [
        'end_date' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class , 'subscription_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class , 'payment_id');
    }

    public function getDaysLeftAttribute()
    {
        $date= $this->end_date->diffInDays(now());
        if (now()->gt($this->end_date)){
            $date=0;
        }
        return $date;
    }

    public function city()
    {
        return $this->belongsTo(City::class , 'city_id');
    }
}
