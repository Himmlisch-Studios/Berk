<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DomainRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validations = [
            !str_starts_with($value, 'http://'),
            !str_starts_with($value, 'https://'),
            filter_var('https://' . $value, FILTER_VALIDATE_URL),
            $url = parse_url('https://' . $value),
            str_contains($url['host'] ?? '', '.'),
            !str_contains($url['host'] ?? '', '..'),
            !isset($url['path'])
        ];
        if (collect($validations)->filter()->count() !== count($validations)) {
            $fail('The :attribute is not a valid domain name.');
        }
    }
}
