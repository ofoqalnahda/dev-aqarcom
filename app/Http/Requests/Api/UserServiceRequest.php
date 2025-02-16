<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserServiceRequest extends FormRequest
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
            'support_service_id' => 'required|exists:support_services,id',

            'cities_ids' => ['required','array','min:1'],
            'cities_ids.*' => ['required','exists:cities,id','distinct'],

            'keywords' => 'required|array|min:1',
            'keywords.*' => 'required|string|min:3|max:255|distinct',
        ];
    }

}
