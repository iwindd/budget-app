<?php

namespace App\Rules;

use App\Models\BudgetItem;
use App\Models\BudgetItemAddress;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AddressBack implements ValidationRule
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
        if ($this->budgetItemAddress->exists) {
            $address = $this->budgetItem->budgetItemAddresses()
                ->where('id', '>', $this->budgetItemAddress->id)
                ->orderBy('id', 'desc')
                ->first(['id', 'from_date']);

            if ($address && $address->from_date < $value) {
                $fromDate = Carbon::parse($address->from_date);
                $fail(__('The selected date must be after the last recorded back date of :date.', [
                    'date' => $fromDate->format('Y-m-d')
                ]));
            }
        }
    }
}
