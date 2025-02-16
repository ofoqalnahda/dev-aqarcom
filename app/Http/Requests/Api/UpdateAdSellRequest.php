<?php

namespace App\Http\Requests\Api;

use App\Models\Ad;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdSellRequest extends APIRequest
{

   public function rules()
    {
        
        return [
            'usage_type_id'     =>  ['required', 'exists:usage_types,id'],
            'description'       =>  ['required' , 'max:1000'],
            'files_removed'    => ['nullable' ],
            'attachment'    => ['nullable' , 'array' , 'min:1'],
            'attachment.*'  => ['mimes:jpg,jpeg,png,gif,bmp,tiff,webp,svg'],
            'videos'    => ['nullable' , 'array' , 'min:1'],
            'video.*'  => ['mimes:mp4,avi,mov,mkv,wmv,flv,3gp,ogg,webm'],
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
