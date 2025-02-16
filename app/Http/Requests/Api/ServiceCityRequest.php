<?php

namespace App\Http\Requests\Api;

use App\Rules\ServiceRequiredValLicense;
use Illuminate\Foundation\Http\FormRequest;

class ServiceCityRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'service_ids' => 'required|array',
            'service_ids.*' => ['required', 'exists:services,id','distinct', new ServiceRequiredValLicense()],
            'city_id' => 'required|exists:cities,id',
        ];
    }
}
