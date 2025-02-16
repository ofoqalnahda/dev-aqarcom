<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BankAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'ar.name'   => ['required' , 'max:30'],
            'en.name'       => ['required' , 'max:30'],
            'account_number'   => ['required' , 'max:255'],
            'iban'       => ['required'  , 'max:255'],
            'image'   => [Rule::requiredIf($this->routeIs('dashboard.bankAccounts.store')) , 'mimes:png,jpg,webp,jpeg'],
        ];
    }
}
