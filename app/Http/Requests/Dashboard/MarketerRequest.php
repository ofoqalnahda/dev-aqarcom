<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\UniqueAcrossTables;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MarketerRequest extends FormRequest
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
//        dd($this->discount_type);
        $rules = [
            'name' => ['nullable', 'max:100'],
            'concerned_party' => ['nullable', 'max:150'],
            'email' => ['nullable', 'max:100', 'email'],
            'phone' => ['nullable', 'digits:10'],
            'identity_number' => ['nullable', 'numeric'],

            'discount_percentage' => ['required', 'numeric', 'min:0',$this->discount_type == 'percent' ? 'max:100' : ''],
            'commission_percentage' => ['required', 'numeric', 'max:100', 'min:0'],
            'code' => ['required', new UniqueAcrossTables([
                'tables' => ['marketers', 'coupons'],
                'exclude_id' => $this->route('marketer') ? $this->route('marketer')->id : null,
                'exclude_table' => 'marketers',
                'id_column' => 'id',
            ])],
            'subscription_ids' => ['required', 'array'],
            'subscription_ids.*' => ['exists:subscriptions,id'],
            'discount_type' => 'required|in:fixed,percent',
            
            'subscription_commission_percentage' => ['required', 'array'],
            'subscription_commission_percentage.*' =>  ['required', 'numeric'],
            'subscription_discount_percentage' => ['required', 'array'],
            'subscription_discount_percentage.*' =>  ['required', 'numeric'],
            'commission_target' => ['nullable', 'numeric'],
            'target_count' => ['nullable', 'numeric'],

            'image' => ['nullable', 'mimes:png,jpeg,jpg,svg'],
        ];
        if($this->method() == "PUT"){
            // unset($rules['code']);
            $rules['identity_number'] = ['required', 'numeric','unique:marketers,identity_number,'.$this->route('marketer')->id];

        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'commission_percentage' => 'نسبة العمولة',
            'discount_percentage' => 'نسبة الخصم',
            'discount_type' => 'نوع الخصم',
        ];
    }
}
