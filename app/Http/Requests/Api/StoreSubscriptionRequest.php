<?php

namespace App\Http\Requests\Api;

use App\Rules\CodeValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends APIRequest
{
    public function rules()
    {
        return [
            'subscription_id'   => ['required' , 'exists:subscriptions,id'],
            'website'           => ['nullable' , 'string' , 'max:100'],
            'about'             => ['nullable' , 'string'],
            'gallery'           => ['nullable' , 'array' ],
            'location'          => ['nullable' , 'string'],
            'lng'               => ['nullable'],
            'lat'               => ['nullable'],
            'facebook'          => ['nullable' , 'url'],
            'instagram'         => ['nullable' , 'url'],
            'twitter'           => ['nullable' , 'url'],
            'linkedin'          => ['nullable' , 'url'],
//            'coupon'            => ['nullable' , 'exists:marketers,code'],
            'coupon'            => ['nullable' , new CodeValidationRule()],
            'snapchat'          => ['nullable' , 'url'],
            'payment_method'    =>['required' , 'in:bank,online'],
            'receipt'           =>[$this->payment_method == 'bank' ? 'required' : 'nullable' , 'mimes:jpg,png,jpeg,webp,pdf']
        ];
    }
}
