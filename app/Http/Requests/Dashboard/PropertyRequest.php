<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PropertyRequest extends FormRequest
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
            'ad_type_id'    => ['required' , 'exists:ad_types,id'],
            'estate_type_id'    => ['required' , 'exists:estate_types,id'],
            'type'                  => ['required' , 'in:slider,multi,switch'],
            'ar.name'                   => ['required' , 'max:30'],
            'en.name'                   => ['required' , 'max:30'],
            'show_outside'              => ['nullable'],
            'image'                     => [Rule::requiredIf($this->routeIs('dashboard.properties.store')) , 'mimes:png,jpeg,jpg,svg'],
            'min_value'                 => [$this->type == 'slider' ? 'required' : 'nullable' ,'numeric', 'min:0' , 'max:'.$this->max_value ],
            'max_value'                 => [$this->type == 'slider' ? 'required' : 'nullable' ,'numeric', 'min:'.$this->min_value],
            'values.ar'             => [Rule::requiredIf($this->type == 'multi')],
            'values.ar.*'       => [Rule::requiredIf($this->type == 'multi') , 'max:30'],
            'values.en'     => [Rule::requiredIf($this->type == 'multi')],
            'values.en.*'     => [Rule::requiredIf($this->type == 'multi') , 'max:30']
        ];
    }
}
