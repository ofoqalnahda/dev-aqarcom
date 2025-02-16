<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CouponRequest;
use App\Models\Coupon;
use App\Models\Marketer;
use App\Models\Subscription;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    use ResponseTrait;
    public function __invoke(CouponRequest $request)
    {

        $coupon = $request->coupon;
        $subscription = Subscription::find($request->subscription_id);
        $price = $subscription->price;
        $marketer = Marketer::where('code' , $coupon)->wherehas('subscriptions',function($q){
                $q->where('subscriptions.id',request('subscription_id'));
            })
            // ->whereJsonContains('subscription_ids', request('subscription_id'))
            ->first();
            // dd($marketer);
        if ($marketer){

            $new_price =$marketer->new_price($price);
        }else{
            $coupon = Coupon::findByCode($coupon ,request('subscription_id'));
            $new_price = $coupon->new_price($price);
        }

        if($new_price < 0){
            $new_price = 0;
        }
        return $this->successResponse(__('applied_successfully'),[
            'new_price' => number_format($new_price ,2),
            'discount' => number_format($price - $new_price ,2)
        ]);
    }
}
