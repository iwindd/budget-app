<?php

namespace App\Livewire\Budgets;

use App\Livewire\Forms\BudgetCompanionForm;
use App\Livewire\Forms\BudgetForm;
use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\BudgetItemExpense;
use App\Models\Invitation;
use App\Models\Office;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BudgetPartial extends Component
{
    public BudgetForm $budgetForm;
    public $hasPermissionToManage = true;
    public $addressSelectize = [];

    public $companions = [];

    public function mount(Request $request)
    {
        $this->budgetForm->setBudget($request->budget);
    }

    public function rules() {
        return [
            'companions' => ['array'],
            'companions.*' => ['integer'],
        ];
    }

    public function save()
    {
        $validated = $this->validate();
        $budget = $this->budgetForm->budget;
        $exists = $budget->exists;

        // fill another fields;
        $validated['user_id'] = $exists ? $budget->user_id : Auth::user()->id;
        $validated['invitation_id'] = $budget->invitation ? $budget->invitation->id : Invitation::getInvitation('id')->id;
        $validated['office_id'] = $budget->office ? $budget->office->id : Office::getOffice('id')->id;
        $validated['addresses'] = json_encode([]);

        // save budget
        $budget->fill($validated);
        $budget->save();

        // update companions
        $currentCompanions = $exists ? $budget->companions()->pluck('user_id') : collect([]);
        $newCompanions     = collect($validated['companions']);

        $companionsToAdd   = $newCompanions->diff($currentCompanions);
        $companionsToRemove = $currentCompanions->diff($newCompanions);

        $budget->companions()->whereIn('user_id', $companionsToRemove)->delete();
        $budget->companions()->createMany($companionsToAdd->map(fn($companion) => ['user_id' => $companion])->all());

        // etc
        $this->dispatch("alert", trans('budgets.alert-budget-saved'));
    }

    public function render()
    {
        return view('livewire.budgets.index');
    }

    public function getDatesBetween($fromDate, $toDate)
    {
/*         $fromDate = Carbon::parse($fromDate);
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

        return $dates; */
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
/*         $this->budgetItemCompanionFrom->save($this->budgetForm->budget);
        return $this->dispatch("alert", trans('budgets.alert-companion-add')); */
    }

    public function onRemoveCompanion(BudgetItem $budgetItem) {
/*         $this->budgetItemCompanionFrom->delete($budgetItem);
        return $this->dispatch("alert", trans('budgets.alert-companion-remove')); */
    }

    /* EXPENSE */
    public function onAddExpense() {
    /*     return $this->budgetItemExpenseForm->save($this->budgetItemForm->budgetItem); */
    }

    public function onRemoveExpense(BudgetItemExpense $budgetItemExpense) {
    /*     return $this->budgetItemExpenseForm->delete($budgetItemExpense); */
    }
}
