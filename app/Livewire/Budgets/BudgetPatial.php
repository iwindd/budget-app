<?php

namespace App\Livewire\Budgets;

use App\Livewire\Forms\BudgetForm;
use App\Livewire\Forms\BudgetItemForm;
use Illuminate\Http\Request;
use Livewire\Component;

class BudgetPatial extends Component
{
    public BudgetForm $budgetForm;
    public BudgetItemForm $budgetItemForm;

    public function mount(Request $request)
    {
        $budget = $this->budgetForm->setBudget($request->budget);
        $this->budgetItemForm->setBudgetItem($budget);
    }

    public function save()
    {
        $this->validate();
        $budget = $this->budgetForm->save();
        $this->budgetItemForm->save($budget);
    }

    public function render()
    {
        return view('livewire.budgets.budget-patial');
    }
}
