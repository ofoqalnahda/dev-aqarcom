<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\UniqueAcrossTables;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
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


        $rules= [
            'code' => [
                'required',
                'string',
                'min:4',
                'max:255',
                new UniqueAcrossTables([
                    'tables' => ['marketers', 'coupons'],
                    'exclude_id' => $this->route('coupon') ? $this->route('coupon')->id : null,
                    'exclude_table' => 'coupons',
                    'id_column' => 'id',
                ])],
            'subscription_ids' => ['required', 'array'],
            'subscription_ids.*' => ['exists:subscriptions,id'],
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:1',
            "expire_date" => "nullable|date|after_or_equal:today",
            "max_usage" => "nullable|numeric|min:1",
            "max_usage_per_user" => "nullable|numeric|min:1",
        ];
        if($this->method() == "PUT"){
            unset($rules['code']);

        }
        return $rules;
    }
}
