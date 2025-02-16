<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{

    public function rules()
    {
        return [
            'old_password' => 'required | min:8',
            'new_password' => 'required | min:8',
        ];
    }
}
