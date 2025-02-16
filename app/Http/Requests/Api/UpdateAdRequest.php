<?php

namespace App\Http\Requests\Api;

use App\Models\Ad;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdRequest extends APIRequest
{

    public function rules()
    {
        return [
            'description'       =>  ['nullable' , 'max:1000'],
            'price'             =>  ['nullable', 'min:0'],
            'min_price'         =>  ['nullable' , 'min:0'],
            'max_price'         =>  ['nullable' , 'min:0'],
            'area'              =>  ['nullable' , 'min:0'],
            'min_area'          =>  ['nullable' , 'min:0'],
            'max_area'          =>  ['nullable' , 'min:0'],
            'mortgage'          =>  ['nullable' , 'max:255'],
            'disputes'          =>  ['nullable' , 'max:255'],
            'commitments'       =>  ['nullable' , 'max:255'],
            'estate_notes'      =>  ['nullable' , 'max:255'],
            'advertiser_orientation_id' =>  [$this->ad->main_type == 'sell' ? 'required' : 'nullable' , 'exists:adv_orientations,id'],
            'advertiser_type'           =>  [$this->ad->main_type == 'sell' ? 'required' : 'nullable' ,'in:owner,delegate'],
            'license_number' =>  [ 'nullable' , 'max:255' ],
            'delegation_number' =>  [ 'nullable' , 'max:255' ],
            'advertiser_registration_number'   => ['nullable' , 'max:255'],
            'attachment'    => ['nullable' , 'array' , 'min:1'],
            'attachment.*'  => ['mimes:jpg,png,jpeg,mp4,avi']
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
            'price' => (float)str_replace(',' , '', $this->price ?? $this->ad->price),
            'area' => (float)str_replace(',' , '' ,$this->area ?? $this->ad->area),
            'min_price' => (float)str_replace(',' , '' ,$this->min_price ?? $this->ad->min_price),
            'min_area' => (float)str_replace(',' , '' ,$this->min_area ?? $this->ad->min_area),
            'max_price' => (float)str_replace(',' , '' ,$this->max_price ?? $this->ad->max_price),
            'max_area' => (float)str_replace(',' , '' ,$this->max_area ?? $this->ad->max_area),
            'advertiser_type' => $this->advertiser_type ? $ad_types[$this->advertiser_type] : null
        ]);
    }
}
