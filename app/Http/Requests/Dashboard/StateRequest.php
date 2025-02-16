<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StateRequest extends FormRequest
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
            'name_ar' => ['required' , 'max:30'],
            'name_en' => ['required' , 'max:30'],
            'lat' => ['required' , 'numeric'],
            'lng' => ['required' , 'numeric'],
        ];
    }
}
