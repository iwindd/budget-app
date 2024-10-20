<?php

namespace App\Rules;

use App\Models\BudgetItem;
use App\Models\BudgetItemAddress;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AddressFrom implements ValidationRule
{
    protected BudgetItem $budgetItem;
    protected BudgetItemAddress $budgetItemAddress;

    public function __construct(BudgetItem $budgetItem, BudgetItemAddress $budgetItemAddress)
    {
        $this->budgetItem = $budgetItem;
        $this->budgetItemAddress = $budgetItemAddress;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = $this->budgetItem->budgetItemAddresses();

        if ($this->budgetItemAddress->exists) {
            $query = $query->where('id', '<', $this->budgetItemAddress->id);
        }

        $address = $query->orderBy('id', 'desc')->first(['id', 'back_date']);
        if ($address && $address->back_date >= $value) {
            $backDate = Carbon::parse($address->back_date);
            $fail(__('The selected date must be after the last back date of :date.', [
                'date' => $backDate->format('Y-m-d')
            ]));
        }
    }
}
