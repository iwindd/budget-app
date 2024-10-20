<?php

namespace App\Livewire\Budgets;

use App\Livewire\Forms\BudgetCompanionForm;
use App\Livewire\Forms\BudgetForm;
use App\Livewire\Forms\BudgetItemAddressForm;
use App\Livewire\Forms\BudgetItemExpenseForm;
use App\Livewire\Forms\BudgetItemForm;
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
    public $hasPermissionToManage = false;

    public function mount(Request $request)
    {
        $budget = $this->budgetForm->setBudget($request->budget);
        $this->budgetItemForm->setBudgetItem($this->budgetItemForm->parseBudgetItem($budget));
        $this->budgetItemAddressForm->setBudgetItemAddress(new BudgetItemAddress());
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

        $this->budgetItemForm->save($budget);
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
        return $this->budgetItemCompanionFrom->save($this->budgetForm->budget);
    }

    public function onRemoveCompanion(BudgetItem $budgetItem) {
        return $this->budgetItemCompanionFrom->delete($budgetItem);
    }

    /* EXPENSE */
    public function onAddExpense() {
        return $this->budgetItemExpenseForm->save($this->budgetItemForm->budgetItem);
    }

    public function onRemoveExpense(BudgetItemExpense $budgetItemExpense) {
        return $this->budgetItemExpenseForm->delete($budgetItemExpense);
    }
}
