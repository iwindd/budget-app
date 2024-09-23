<?php

namespace App\Rules;

use App\Models\Budget;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AddressFrom implements ValidationRule
{
    protected string $budget;
    protected string $user_id;
    protected int $max_id;

    public function __construct(string $budget, string $user_id, int $max_id)
    {
        $this->budget = $budget;
        $this->user_id = $user_id;
        $this->max_id = $max_id;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $budget = Budget::where('serial', $this->budget)->first();
        if (!$budget) { $fail(__('The specified budget could not be found.')); return; }

        $item = $budget->budgetItems()->where('user_id', $this->user_id)->first();
        if (!$item) { $fail(__('The specified budget could not be found.')); return; }

        $query = $item->addresses();

        if (($this->max_id) - 1 > 0) {
            $query = $query->where('id', '<=', ($this->max_id) - 1);
        }

        // Use an array to pass multiple columns to the `first()` method
        $lastAddress = $query->orderBy('id', 'desc')->first(['id', 'back_date']);

        if ($lastAddress) {
            // Ensure that the `back_date` is earlier than the `$value`
            if ($lastAddress->back_date >= $value) {
                $backDate = Carbon::parse($lastAddress->back_date);

                $fail(__('The selected date must be after the last back date of :date.', [
                    'date' => $backDate->format('Y-m-d')
                ]));
            }
        }
    }
}
