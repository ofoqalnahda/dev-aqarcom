<?php

namespace App\Rules;

use App\Models\Coupon;
use App\Models\Marketer;
use Illuminate\Contracts\Validation\Rule;

class CodeValidationRule implements Rule
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
        $coupon = Coupon::findByCode($value , request('subscription_id'));
        return $coupon || Marketer::where('code', $value)
        ->wherehas('subscriptions',function($q){
                $q->where('subscriptions.id',request('subscription_id'));
            })
        // ->whereJsonContains('subscription_ids',request('subscription_id'))
        ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('wrong_coupon');
    }
}
