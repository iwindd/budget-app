<?php

namespace App\Livewire\Budgets;

use App\Livewire\Forms\BudgetCompanionForm;
use App\Livewire\Forms\BudgetForm;
use App\Livewire\Forms\BudgetItemAddressForm;
use App\Livewire\Forms\BudgetItemExpenseForm;
use App\Livewire\Forms\BudgetItemForm;
use App\Livewire\Forms\BudgetItemTravelForm;
use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\BudgetItemAddress;
use App\Models\BudgetItemExpense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;

class BudgetPartial extends Component
{
    public BudgetForm $budgetForm;
    public BudgetItemForm $budgetItemForm;
    public BudgetCompanionForm $budgetItemCompanionFrom;
    public BudgetItemAddressForm $budgetItemAddressForm;
    public BudgetItemExpenseForm $budgetItemExpenseForm;
    public BudgetItemTravelForm  $budgetItemTravelForm;
    public $hasPermissionToManage = false;
    public $addressSelectize = [];

    public function mount(Request $request)
    {
        $budget = $this->budgetForm->setBudget($this->budgetForm->parseBudget($request->budget));
        $budgetItem = $this->budgetItemForm->parseBudgetItem($budget);
        $this->budgetItemForm->setBudgetItem($budgetItem);
        $this->budgetItemTravelForm->setBudgetItemTravel($budgetItem);
        $this->hasPermissionToManage = $this->budgetItemCompanionFrom->hasPermissionToManage($budget);
      /*   $this->setAddresses($budgetItem->exists ? $budgetItem->budgetItemAddresses->toArray() : []); */
        $this->addressSelectize = Budget::Addresses()->toArray();
    }

    public function save()
    {
        $this->validate();
        $budget = null;

        if ($this->hasPermissionToManage) {
            $budget = $this->budgetForm->save();
        } else {
            $budget = $this->budgetForm->exists() ?
                $this->budgetForm->budget :
                $this->budgetForm->save();
        }

        $budgetItem = $this->budgetItemForm->save($budget);
        $this->budgetForm->setBudget($budget);
        $this->budgetItemForm->setBudgetItem($budgetItem);
        $this->budgetItemTravelForm->setBudgetItemTravel($budgetItem);
        $this->hasPermissionToManage = $this->budgetItemCompanionFrom->hasPermissionToManage($budget);
        $this->dispatch("alert", trans('budgets.alert-budget-saved'));
    }

    public function render()
    {
        return view('livewire.budgets.index');
    }

    public function getDatesBetween($fromDate, $toDate)
    {
        $fromDate = Carbon::parse($fromDate);
        $toDate = Carbon::parse($toDate);
        $backDate = Carbon::parse($toDate);

        $dates = [];
        while ($fromDate->lte($toDate)) {
            $dates[] = [
                $fromDate->format('Y-n-j H:i'),
                $backDate->year($fromDate->year)->month($fromDate->month)->day($fromDate->day)->format('Y-n-j H:i')
            ]; // Customize the format as needed
            $fromDate->addDay();
        }

        return $dates;
    }

    /* ADDRESS */
    private function splitDates(array $dates)
    {
        $carbonDates = collect($dates)
            ->map(fn($date) => Carbon::parse($date))
            ->sort()
            ->values(); // Reindex after sorting

        $result = [];
        $tempGroup = [$carbonDates[0]];

        for ($i = 1; $i < $carbonDates->count(); $i++) {
            if ($carbonDates[$i]->diffInDays($carbonDates[$i - 1]) === 1) {
                $tempGroup[] = $carbonDates[$i];
            } else {
                $result[] = $tempGroup;
                $tempGroup = [$carbonDates[$i]];
            }
        }

        if (count($tempGroup)) {
            $result[] = $tempGroup;
        }

        return collect(array_map(function ($group) {
            return array_map(fn($date) => $date->format('Y-m-d'), $group);
        }, $result));
    }

    public function onAddAddress() {
        $validated = $this->budgetItemAddressForm->submit();
        $payload   = Budget::ExtractAddresses($this->budgetForm->addresses);

        if ($validated['multiple']){
            $stackDates = $this->splitDates($validated['dates']);

            $stackDates->map(function($dates) use ($payload, $validated){
                collect($dates)->map(function($date) use ($payload, $validated) {
                    $fromDate = Carbon::parse($date . ' ' . $validated['from_time']);
                    $backDate = Carbon::parse($date . ' ' . $validated['back_time']);

                    if (Budget::GetEventBetween($payload, $fromDate, $backDate)->isNotEmpty())
                        return $this->addError('dates', trans('address.validation-overlap'));

                    $payload->push([
                        'from_date' => $fromDate->format('Y-m-d H:i'),
                        'back_date' => $backDate->format('Y-m-d H:i')
                    ] + $validated);
                });
            });
        }else{
            $fromDate = Carbon::parse($validated['dates'][0] . ' ' . $validated['from_time']);
            $backDate = Carbon::parse($validated['dates'][count($validated['dates'])-1] . ' ' . $validated['back_time']);

            if (Budget::GetEventBetween($payload, $fromDate, $backDate)->isNotEmpty())
                return $this->addError('dates', trans('address.validation-overlap'));

            $payload->push([
                'from_date' => $fromDate->format('Y-m-d H:i'),
                'back_date' => $backDate->format('Y-m-d H:i')
            ] + $validated);
        }

        $this->budgetItemAddressForm->clear();
        $this->budgetForm->addresses = Budget::MinimizeAddresses($payload)->toArray();
    }

    /* COMPANION */
    public function onAddCompanion() {
        $this->budgetItemCompanionFrom->save($this->budgetForm->budget);
        return $this->dispatch("alert", trans('budgets.alert-companion-add'));
    }

    public function onRemoveCompanion(BudgetItem $budgetItem) {
        $this->budgetItemCompanionFrom->delete($budgetItem);
        return $this->dispatch("alert", trans('budgets.alert-companion-remove'));
    }

    /* EXPENSE */
    public function onAddExpense() {
        return $this->budgetItemExpenseForm->save($this->budgetItemForm->budgetItem);
    }

    public function onRemoveExpense(BudgetItemExpense $budgetItemExpense) {
        return $this->budgetItemExpenseForm->delete($budgetItemExpense);
    }

    /* TRAVEL */
    public function onSaveTravel() {
        return $this->budgetItemTravelForm->save($this->budgetItemForm->budgetItem);
    }
}
