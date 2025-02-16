<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ar.title'          => ['required' , 'max:191'],
            'en.title'          => ['required' , 'max:191'],
            'ar.description'    => ['required' ],
            'en.description'    => ['required' ],
            'image'             => [Rule::requiredIf($this->routeIs('dashboard.blogs.store')) , 'mimes:png,jpg,webp,jpeg'],
        ];
    }
}
