<?php

namespace App\Rules;

use App\Models\BudgetItem;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoHaveEvent implements ValidationRule
{
    protected $fromTime;
    protected $backTime;
    protected $isMultiple;
    protected BudgetItem $budgetItem;

    public function __construct($fromTime = null, $backTime = null, $isMultiple = false, BudgetItem $budgetItem)
    {
        $this->fromTime = $fromTime;
        $this->backTime = $backTime;
        $this->isMultiple = $isMultiple;
        $this->budgetItem = $budgetItem;
    }

    // Correct signature for validate()
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (count($value) < ($this->isMultiple ? 1 : 2)) {
            $fail(':attribute invalid!');
            return;
        }

        $hasEvent = false;

        if (!$this->isMultiple) {
            $startDate = Carbon::parse($value[0] . ' ' . $this->fromTime);
            $endDate = Carbon::parse($value[1] . ' ' . $this->backTime);

            $hasEvent = BudgetItem::GetAddressBetween($this->budgetItem, [$startDate], [$endDate])->exists();
        }else{
            $startDates = [];
            $endDates = [];

            collect($value)->each(function ($date) use (&$startDates, &$endDates) {
                $startDates[] = Carbon::parse($date . ' ' . $this->fromTime);
                $endDates[] = Carbon::parse($date . ' ' . $this->backTime);
            });

            $hasEvent = BudgetItem::GetAddressBetween($this->budgetItem, $startDates, $endDates)->exists();
        }

        if ($hasEvent) {
            $fail('There are overlapping events for the specified dates.');
        }
    }
}
