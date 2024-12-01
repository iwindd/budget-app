<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidUserId implements ValidationRule
{
    protected array $related;

    public function __construct(array $related)
    {
        $this->related = $related;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array($value, $this->related)) {
            $fail(':attribute ที่เลือกไม่เกี่ยวข้องกับใบเบิกนี้!');
        }
    }
}
