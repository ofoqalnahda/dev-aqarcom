<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketer extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'subscription_ids' => 'array',
    ];

    public function user(){
        return $this->hasOne(User::class , 'id' , 'user_id');
    }
    public function draws(){
        return $this->HasMany(Draw::class , 'marketer_id');
    }
    public function couponsUsageCount($is_active =1){
        $code = $this->code;
        $count= UserSubscription::where('coupon' , $code)->where('is_active' , $is_active)->count();
        return $count;

    }
    public function transactions(){
        return $this->HasMany(MarketerTransaction::class , 'marketer_id');
    }
    public function subscriptionsName()
    {
        if ($this->subscriptions()->exists()) { // Check if subscriptions exist
            $names = [];
            foreach ($this->subscriptions as $subscription) {
                $names[] = $subscription->name . ' - %' . $subscription->pivot->commission_percentage;
            }
            return implode(', ', $names);
        }
    
        return '';
    }

    public function subscriptions()
    {
        return $this->belongsToMany(Subscription::class,MarketerSubscription::class)->withPivot('commission_percentage','discount_percentage');

    }
    public function discount($total)
    {
       $discount_percentage= $this->discount_percentage;
        if(request('subscription_id')){
          $subscription=  $this->subscriptions()->where('subscriptions.id',request('subscription_id'))->first();
           $discount_percentage= $subscription?$subscription->pivot->discount_percentage:$this->discount_percentage;
        }
       
        if ($this->discount_type == "fixed") {
            return $discount_percentage;
        } else {
            return ($discount_percentage / 100) * $total;
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
}
