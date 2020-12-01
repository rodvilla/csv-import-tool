<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ContainsRequiredFields implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return in_array('team_id', $value)
            && in_array('phone', $value)
            && in_array('sticky_phone_number_id', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The fields [Team ID, Phone and Sticky Phone Number ID] are required';
    }
}
