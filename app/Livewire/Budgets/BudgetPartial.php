<?php

namespace App\Livewire\Budgets;

use App\Livewire\Forms\BudgetCompanionForm;
use App\Livewire\Forms\BudgetForm;
use App\Livewire\Forms\BudgetItemAddressForm;
use App\Livewire\Forms\BudgetItemExpenseForm;
use App\Livewire\Forms\BudgetItemForm;
use App\Livewire\Forms\BudgetItemTravelForm;
use App\Models\BudgetItem;
use App\Models\BudgetItemAddress;
use App\Models\BudgetItemExpense;
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

    public function mount(Request $request)
    {
        $budget = $this->budgetForm->setBudget($this->budgetForm->parseBudget($request->budget));
        $budgetItem = $this->budgetItemForm->parseBudgetItem($budget);
        $this->budgetItemForm->setBudgetItem($budgetItem);
        $this->budgetItemAddressForm->setBudgetItemAddress(new BudgetItemAddress());
        $this->budgetItemTravelForm->setBudgetItemTravel($budgetItem);
        $this->hasPermissionToManage = $this->budgetItemCompanionFrom->hasPermissionToManage($budget);
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

    /* ADDRESS */
    public function onAddAddress() {
        return $this->budgetItemAddressForm->save($this->budgetItemForm->budgetItem);
    }

    public function onEditAddress(BudgetItemAddress $address) {
        return $this->budgetItemAddressForm->setBudgetItemAddress($address);
    }

    public function onCancelEditAddress() {
        return $this->budgetItemAddressForm->setBudgetItemAddress(new BudgetItemAddress());
    }

    public function onRemoveAddress(BudgetItemAddress $address) {
        return $address->delete();
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
