<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AfterSellServicesRequest extends FormRequest
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
            'ar.title'  => ['required' , 'max:256'],
            'en.title'  => ['required' , 'max:256'],
            'image'     => [Rule::requiredIf($this->isMethod('POST')) , 'mimes:png,jpg,jpeg,webp']
        ];
    }
}
