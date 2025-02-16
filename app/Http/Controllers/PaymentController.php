<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Marketer;
use App\Models\Donation;
use App\Services\PaymentService;
use App\Traits\MarketerTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use MarketerTransaction;
    public function create(Request $request , float $amount)
    {
        $url = $request->url;
        return view('payment' , compact('amount' , 'url'));
    }

    public function store(Request $request ,  string $process , ?User $user , ?Subscription $subscription)
    {
        $payment = PaymentService::getPayment($request->id);
//        dd($payment);
        if($payment['status'] == 'paid'){
            if($process == 'verification'){
                $user->pending_authentication = 1;
                $user->payment_id = PaymentService::createOnlinePayment($payment['id']);
                $user->save();
            }elseif($process == 'subscription'){
                $oldSubscription = $user->subscription()->first();
                $subscriptionData['regular_ads'] = $subscription->regular_ads +(int) $oldSubscription?->pivot?->regular_ads;
                $subscriptionData['special_ads'] = $subscription->special_ads +(int) $oldSubscription?->pivot?->special_ads;
                $subscriptionData['price'] = $payment['amount']/100;
                $subscriptionData['end_date'] = Carbon::now()->addDays($subscription->duration);
                $subscriptionData['coupon'] = $request->coupon;
                $subscriptionData['payment_id'] = PaymentService::createOnlinePayment($payment['id'], $payment['source']['company']);
                $subscriptionData['is_active'] = 1;
                $user->subscription()->sync([$subscription->id =>  $subscriptionData]);

                if($request->coupon){
                    $marketer  = Marketer::where('code' , $request->coupon)->first();
                    if($marketer){
                        $marketer->balance += ($request->amount/100) * ($marketer->commission_percentage / 100);
                        $marketer->save();
                        $this->storeTransaction($marketer , $user->subscription()->first()->pivot);
                    }else{
                        $coupon = Coupon::findByCode($request->coupon , $user->subscription()->first()->id);
                        if($coupon){
                            $coupon->burn($user);
                        }
                    }
                }
            }elseif($process == 'donation'){
                Donation::create([
                    'user_id' => $request->user_id,
                    'amount'  => $payment['amount']/100,
                    'payment_id' => $payment['id']
                ]);
            }
        }
        return view('payment_callback' , compact('payment'));
    }
}
