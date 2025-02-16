<?php

namespace App\Http\Requests\Api;

class ContactUsRequest extends APIRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required | digits:10',
            'message' => 'required|string|min:10|max:500',
            'fname' => 'nullable|string|min:3|max:50',
            'lname' => 'nullable|string|min:3|max:50',
            'email' => 'nullable|email',
            'subject' => 'nullable|string|min:3|max:50',
        ];
    }
}
