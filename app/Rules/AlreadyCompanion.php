<?php

namespace App\Rules;

use App\Models\Budget;
use App\Models\BudgetItem;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AlreadyCompanion implements ValidationRule
{
    protected string $budget;

    public function __construct(string $budget)
    {
        $this->budget = $budget;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Find the budget based on the serial number
        $budget = Budget::where('serial', $this->budget)->first();

        // If the budget doesn't exist, fail with the appropriate message
        if (!$budget) {
            $fail(__('Budget not found.'));
            return;
        }

        // Check if the user is already in the budget as a companion
        if ($budget->budgetItems()->where('user_id', $value)->exists()) {
            $fail(__('This user is already a companion in the budget.'));
        }
    }
}
