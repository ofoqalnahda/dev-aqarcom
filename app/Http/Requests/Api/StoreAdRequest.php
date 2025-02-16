<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdRequest extends APIRequest
{

    public function rules()
    {
        return [
            'special'           =>  ['nullable' , 'boolean'],
            'city_id'           =>  ['required', 'exists:cities,id'],
            'neighborhood_id'   =>  ['nullable'],
            'area_id'           =>  ['required', 'exists:areas,id'],
            'estate_type_id'    =>  ['required', 'exists:estate_types,id'],
            'ad_type_id'        =>  ['required', 'exists:ad_types,id'],
            'usage_type_id'     =>  ['required', 'exists:usage_types,id'],
            'description'       =>  ['required' , 'max:1000'],
            'price'         =>  [ 'required' , 'min:0'],
            'area'          =>  [ 'required' , 'min:0'],
            'mortgage'          =>  ['nullable' , 'max:255'],
            'disputes'          =>  ['nullable' , 'max:255'],
            'commitments'       =>  ['nullable' , 'max:255'],
            'estate_notes'      =>  ['nullable' , 'max:255'],
            'license_number' =>  [ 'nullable' , 'max:255' ],
            'delegation_number' =>  [ 'nullable' , 'max:255' ],
            'advertiser_registration_number'   => ['nullable' , 'max:255'],
            'attachment'    => ['nullable' , 'array' , 'min:1'],
            'options'    => ['nullable' , 'array' , 'min:1'],
            'attachment.*'  => ['mimes:jpg,png,jpeg,mp4,avi,webp'],
            'is_story'  => ['nullable' , 'boolean']
        ];
    }


    protected function prepareForValidation()
    {
        $ad_types = [
            'مالك' => 'owner',
            'مرخص' => 'delegate',
            'owner' => 'owner',
            'delegate' => 'delegate',
        ];
        $this->merge([
            'price' => convert_to_english_numbers($this->price),
            'area' => convert_to_english_numbers($this->area)
        ]);
        
    }
}
