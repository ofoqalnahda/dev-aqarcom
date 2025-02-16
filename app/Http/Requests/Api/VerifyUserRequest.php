<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class VerifyUserRequest extends APIRequest
{
    public function rules()
    {
        return [
            'account_type_id'           =>['required' , 'exists:account_types,id'],
            'identity_owner_name'       =>['required' , 'string' , 'max:50'],
            'identity_number'           =>['required' , 'string' , 'max:50'],
            'commercial_owner_name'     =>['required' , 'string' , 'max:50'],
            'commercial_name'           =>['required' , 'string' , 'max:50'],
            'commercial_number'         =>['required' , 'string' , 'max:50'],
            'commercial_image'          =>[auth()->user()->pending_authentication == 0 ? 'required' : 'nullable' , 'mimes:jpg,png,jpeg,webp'],
            'identity_image'            =>[auth()->user()->pending_authentication == 0 ? 'required' : 'nullable' , 'mimes:jpg,png,jpeg,webp'],
            'payment_method'            =>[auth()->user()->pending_authentication == 0 ? 'required' : 'nullable' , 'in:bank,online'],
            'receipt'                   =>[$this->payment_method == 'bank' ? 'required' : 'nullable' , 'mimes:jpg,png,jpeg,webp,pdf']
        ];
    }
}
