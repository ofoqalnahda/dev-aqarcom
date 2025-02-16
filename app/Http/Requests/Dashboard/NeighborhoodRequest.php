<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class NeighborhoodRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'city_id'=> ['required' , 'exists:cities,id'],
            'ar.name'=> ['required' , 'max:30'],
            'en.name'=> ['required' , 'max:30'],
        ];
    }
}
