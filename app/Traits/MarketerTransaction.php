<?php

namespace App\Traits;
use App\Models\Marketer;

trait MarketerTransaction {
    public function storeTransaction($marketer , $subscription){
        Marketer::findorfail($marketer->id)->transactions()->create([
            'user_id' => $subscription->user_id,
            'amount'=> $subscription->price,
            'subscription_id' => $subscription->subscription_id,
            'payment_id' => $subscription->payment_id,
            'marketer_id' => $marketer->id,

        ]);



    }
}
