<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends APIRequest
{

    public function rules()
    {
        return [
            'password'=>['required' ,'min:8', 'confirmed']
        ];
    }
}
