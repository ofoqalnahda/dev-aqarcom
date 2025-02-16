<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends APIRequest
{
    public function rules()
    {
        return [
            'name'      =>['nullable' , 'string' ,'max:199'],
            'email'     =>['nullable' , 'email' , Rule::unique('users')->ignore(auth()->id()) , 'max:199'],
            'phone'     =>['nullable' , 'digits:10' ,'starts_with:05' ,  Rule::unique('users')->ignore(auth()->id())],
            'whatsapp'  =>['nullable' , 'digits:10' ,'starts_with:05' , Rule::unique('users')->ignore(auth()->id())],
            'image'     =>['nullable' , 'mimes:jpg,png,webp' , 'max:5120'],
            'city_id'   =>[auth()->user()->city_id?"nullable":"required", 'exists:cities,id'],
        ];
    }

    protected function prepareForValidation()
    {
        if($this->phone)
            $this->merge([
                'phone' => ( $this->phone && $this->phone[0] == '0' ) ? $this->phone : '0' .  $this->phone,
            ]);

        if($this->whatsapp)
            $this->merge([
                'whatsapp' => ( $this->whatsapp && $this->whatsapp[0] == '0' ) ? $this->whatsapp : '0' .  $this->whatsapp,
            ]);
    }
}
