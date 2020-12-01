<?php

namespace App\Rules;

use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Validation\Rule;

class FileExists implements Rule
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
        return Storage::exists($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The uploaded CSV doesn't exist anymore, please refresh the page";
    }
}
