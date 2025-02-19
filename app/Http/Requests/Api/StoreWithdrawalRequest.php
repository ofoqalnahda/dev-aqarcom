<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreWithdrawalRequest extends APIRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'account_number'         => ['required' , 'starts_with:SA', 'size:24'],
            'name'      => ['required' , 'min:6' , 'max:191'],
            'amount'  => ['required', "regex:/^\d+(\.\d{1,2})?$/" ],
        ];
    }
}
