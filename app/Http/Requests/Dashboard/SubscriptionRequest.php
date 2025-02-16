<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'ar.name'       => ['required' , 'max:191'],
            'en.name'           => ['required' , 'max:191'],
            'ar.description'        => ['required' , 'max:1500'],
            'en.description'            => ['required' , 'max:1500'],
            'price'                         => ['required' , 'numeric' , 'min:0'],
            'regular_ads'                   => ['required' , 'numeric' , 'min:0'],
            'special_ads'               => ['required' , 'numeric' , 'min:0'],
            'duration'              => ['required' , 'numeric' , 'min:1'],
            'premium'           => ['nullable'],
            'location'      => ['nullable'],
            'features'      => ['required'],
            'old_price'      => ['nullable' , 'numeric' , 'min:0'],
        ];
    }
}
