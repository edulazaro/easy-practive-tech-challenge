<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmailWithTLDRule implements Rule
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
        return preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $value) > 0;
    }

    /**
     * Get the error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid email address with a top-level domain.';
    }
}
