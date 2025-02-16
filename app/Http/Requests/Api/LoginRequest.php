<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'phone'         => ['required' , 'starts_with:05', 'digits:10'],
            'password'      => ['required' , 'min:8' , 'max:191'],
            'device_token'  => ['required' , 'string']
        ];
    }
}
