<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 
        $pattern = '/^((\+\d{1,2})?\(?\d{3}\)?\d{3}[-]?\d{2}[-]?\d{2})$/';
        if (!preg_match($pattern, $value)) {
            $fail("The $attribute is not a valid phone number.");
        }
    }
}
