<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriptionRequest extends APIRequest
{
    public function rules()
    {
        return [
            'website'           => ['nullable' , 'string' , 'max:100'],
            'about'             => ['nullable' , 'string'],
            'gallery'           => ['nullable' , 'array' ],
            // new
            'gallery.*'         => ['array'],
            'gallery.*.title'      => ['required_with:gallery.*' , 'string','min:3' , 'max:100'],
            'gallery.*.image'      => ['required_with:gallery.*' , 'mimes:jpg,png,jpeg,webp'],
            // end new
            'location'          => ['nullable' , 'string'],
            'city_id'           => ['nullable' , 'exists:cities,id'],
            'lng'               => ['nullable'],
            'lat'               => ['nullable'],
            'facebook'          => ['nullable'],
            'instagram'         => ['nullable'],
            'twitter'           => ['nullable'],
            'snapchat'          => ['nullable'],
            'linkedin'          => ['nullable'],
            'facebook_status'          => ['nullable'],
            'instagram_status'         => ['nullable'],
            'twitter_status'           => ['nullable'],
            'snapchat_status'          => ['nullable'],
            'website_status'          => ['nullable'],
            'linkedin_status'          => ['nullable'],
//             'services'          => ['nullable' , 'array'],
        ];
    }
}
