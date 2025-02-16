<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketerTransaction extends Model
{
    use HasFactory;
    protected $guarded= ['id'];

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

}
