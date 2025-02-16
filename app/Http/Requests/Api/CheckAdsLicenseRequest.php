<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckAdsLicenseRequest extends APIRequest
{

    public function rules()
    {
        return [
            'license_number' =>  [ 'required' , 'max:255' ],
        ];
    }

}
