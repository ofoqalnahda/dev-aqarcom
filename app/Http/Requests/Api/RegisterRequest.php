<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends APIRequest
{

    public function rules()
    {
        return [
            'name'      =>['nullable' , 'string' ,'max:199'],
            'email'     =>['nullable' , 'email' ,'unique:users' , 'max:199'],
            'phone'     =>['required' , 'digits:10' ,'starts_with:05' , 'unique:users'],
            'whatsapp'  =>['nullable' , 'digits:10' ,'starts_with:05' , 'unique:users'],
            'password'  =>['required' , 'confirmed' ,'min:8' , 'max:199'],
            'image'     =>['nullable' , 'mimes:jpg,png,webp' , 'max:5120'],
            'device_token'     =>['sometimes' , 'nullable' ],
//            'city_id'   =>['nullable' , 'exists:cities,id'],
        ];
    }
}
