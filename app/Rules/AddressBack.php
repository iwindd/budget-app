<?php

namespace App\Rules;

use App\Models\Budget;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AddressBack implements ValidationRule
{
    protected string $budget;
    protected string $user_id;
    protected int $start_id;

    public function __construct(string $budget, string $user_id, int $start_id)
    {
        $this->budget = $budget;
        $this->user_id = $user_id;
        $this->start_id = $start_id;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->start_id > 0) {
            $budget = Budget::where('serial', $this->budget)->first();
            if (!$budget) { $fail(__('The specified budget could not be found.')); return; }

            $item = $budget->budgetItems()->where('user_id', $this->user_id)->first();
            if (!$item) { $fail(__('The specified budget could not be found.')); return; }

            $newAddress = $item->addresses()
                ->where('id', '>', $this->start_id)
                ->orderBy('id', 'desc')
                ->first(['id', 'from_date']);

            if ($newAddress) {
                if ($newAddress->from_date < $value) {
                    $fromDate = Carbon::parse($newAddress->from_date);
                    $fail(__('The selected date must be after the last recorded back date of :date.', [
                        'date' => $fromDate->format('Y-m-d')
                    ]));
                }
            }
        }
    }
}
