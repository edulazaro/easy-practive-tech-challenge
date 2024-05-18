<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneRule implements Rule
{
    /**
     * Check if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^(\+)?[\d\s]+$/', $value);
    }

    /**
     * Get the error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid phone number.';
    }
}
