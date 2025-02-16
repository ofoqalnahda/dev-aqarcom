<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ar.name' => ['required' , 'string' , 'max:20'],
            'en.name' => ['required' , 'string' , 'max:20']
        ];
    }
}
