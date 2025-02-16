<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ServiceRequiredValLicense implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $service = \App\Models\Service::find($value);
        $user_licensed = auth('api')->user()->val_license;

        return $service->is_val_required && !$user_licensed ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('service_required_val_license');
    }
}
