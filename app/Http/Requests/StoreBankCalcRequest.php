<?php

namespace App\Http\Requests;

use App\Models\BankCalc;
use Illuminate\Foundation\Http\FormRequest;

class StoreBankCalcRequest extends FormRequest
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
        $validations  =[
            'name' => 'required|string|max:255',
            'national_id' => 'required|numeric|digits:10',
            'birth_date' => 'required|date|before:today',
            'salary' => 'required|numeric',
            'contact_number' => ['required' , 'digits:10' ,'starts_with:05'],
            'email' => 'required|email|max:255',
            'job' => ['required' , 'in:'.implode(',' , BankCalc::jobTypes())],
            'job_name' => ['required','string','max:255'],
            'financial_obligations' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'gov_supported' => 'required|boolean',
        ];
        if($this->job =='عسكري'){

            $validations['job_name'] = ['required' , 'in:'.implode(',' , BankCalc::militaryJobTypes())];
        }

        return $validations;
    }
}
