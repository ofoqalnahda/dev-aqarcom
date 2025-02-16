<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AccountTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ar.name'   => ['required' , 'max:30'],
            'en.name'   => ['required' , 'max:30'],
            'price'     => ['required' , 'numeric' , 'min:1']
        ];
    }
}
