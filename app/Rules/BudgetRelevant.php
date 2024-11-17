<?php

namespace App\Rules;

use App\Models\Budget;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class BudgetRelevant implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  Closure  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $budgets = Budget::where('serial', $value)->get(['id', 'user_id']);
        $auth    = Auth::user();
        $relevant = false;

        foreach ($budgets as $budget) {
            if ($budget->user_id == $auth->id) $relevant = true;
            if ($budget->companions()->where('user_id', $auth->id)->first()) $relevant = true;

            if ($relevant) break;
        }

        if (!$relevant) $fail('ไม่พบใบเบิกดังกล่าว');
    }
}
