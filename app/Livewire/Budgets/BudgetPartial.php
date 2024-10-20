<?php

namespace App\Livewire\Budgets;

use App\Livewire\Forms\BudgetForm;
use App\Livewire\Forms\BudgetItemAddressForm;
use App\Livewire\Forms\BudgetItemForm;
use App\Models\BudgetItemAddress;
use Illuminate\Http\Request;
use Livewire\Component;

class BudgetPartial extends Component
{
    public BudgetForm $budgetForm;
    public BudgetItemForm $budgetItemForm;
    public BudgetItemAddressForm $budgetItemAddressForm;

    public function mount(Request $request)
    {
        $budget = $this->budgetForm->setBudget($request->budget);
        $this->budgetItemForm->setBudgetItem($budget);
        $this->budgetItemAddressForm->setBudgetItemAddress(new BudgetItemAddress());
    }

    public function save()
    {
        $this->validate();
        $budget = null;

        if ($this->budgetForm->owner()) {
            $budget = $this->budgetForm->save();
            $this->budgetItemForm->save($budget);
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

}
