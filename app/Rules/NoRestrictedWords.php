<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoRestrictedWords implements ValidationRule
{
    protected $restrictedWords = ['дурак', 'плохое', 'запрещено']; // Запрещенные слова

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($this->restrictedWords as $word) {
            if (stripos($value, $word) !== false) {
                $fail('Описание содержит запрещенные слова!');
            }
        }
    }
}
