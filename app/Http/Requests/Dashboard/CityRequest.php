<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
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
            'area_id' => ['required' , 'exists:areas,id'],
            'state_id' => ['required' , 'exists:states,id'],
            'ar.name' => ['required' , 'max:30'],
            'en.name' => ['required' , 'max:30'],
            'lat' => ['required' , 'numeric'],
            'lng' => ['required' , 'numeric'],
        ];
    }
}
