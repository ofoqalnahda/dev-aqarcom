<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdSellRequest extends APIRequest
{

    public function rules()
    {
        
        return [
            'special'           =>  ['nullable' , 'boolean'],
         
            'usage_type_id'     =>  ['required', 'exists:usage_types,id'],
            'description'       =>  ['required' , 'max:1000'],
            'location'          =>  ['nullable'   , 'max:255'],
            'lng'               =>  ['required'],
            'lat'               =>  [ 'required' ],
            'mortgage'          =>  ['nullable' , 'max:255'],
            'disputes'          =>  ['nullable' , 'max:255'],
            'commitments'       =>  ['nullable' , 'max:255'],
            'estate_notes'      =>  ['nullable' , 'max:255'],
            // 'advertiser_orientation_id' =>  ['required' , 'exists:adv_orientations,id'],
            // 'advertiser_type'           =>  [ 'required'  ,'in:owner,delegate'],
            'license_number' =>  [ 'nullable' , 'max:255' ],
            'delegation_number' =>  [ 'nullable' , 'max:255' ],
            'advertiser_registration_number'   => ['nullable' , 'max:255'],
            'attachment'    => ['nullable' , 'array' , 'min:1'],
            'options'    => ['nullable' , 'array' , 'min:1'],
            'attachment.*'  => ['mimes:jpg,jpeg,png,gif,bmp,tiff,webp,svg,mp4,avi,mov,mkv,wmv,flv,3gp,ogg,webm'],
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
        
    }
}
