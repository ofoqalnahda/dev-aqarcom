<?php

namespace App\Http\Requests\Api;

use App\Rules\CodeValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends APIRequest
{
    public function rules()
    {
        return [
            'subscription_id'=>['required' , 'exists:subscriptions,id'],
            'coupon' => [
                'required' ,
                'max:255',
//                'exists:marketers,code',
                new CodeValidationRule()
            ],

            'price' => ['nullable','min:0'],
        ];
    }

    public function messages()
    {
        return [
            'coupon.exists' => __('wrong_coupon'),
            'subscription_ids.*.min' => __('at_least_one_subscription'),
        ];
    }

    public function attributes()
    {
        return
        [
            'subscription_id' => __('subscription'),
            'coupon' => __('coupon'),
            'price' => __('price'),
        ];
    }
}
