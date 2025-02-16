<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupportServiceAdsRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'support_service_id' => 'required|integer|exists:support_services,id',
            'area_id' => 'required|integer|exists:areas,id',
            'city_id' => ['required', 'integer', Rule::exists('cities', 'id')
                                                    ->where('area_id', $this->area_id)
            ],
            'attachments' => 'required|array|min:1',
            'attachments.*' => ['mimes:jpg,png,jpeg,mp4,avi,webp'],
        ];
    }
}
