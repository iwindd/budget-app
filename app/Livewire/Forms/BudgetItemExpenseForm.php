<?php

namespace App\Livewire\Forms;

use App\Models\BudgetItem;
use App\Models\BudgetItemExpense;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class BudgetItemExpenseForm extends Form
{
    //
    public $expense_id;
    public $days;
    public $total;

    public function clear()
    {
        $this->reset();
        $this->getComponent()->dispatch("onExpenseSelectorClear");
    }

    public function delete(BudgetItemExpense $budgetItemExpense)
    {
        $budgetItemExpense->delete();
    }

    private function create()
    {
        $validated = $this->validate([
            'expense_id' => ['required', 'string', 'max:255'],
        ]);

        return Expense::firstOrCreate(['label' => $validated['expense_id']],[
            'user_id' => Auth::user()->id,
            'label' => $validated['expense_id'],
            'merge' => true,
            'default' => false
        ]);
    }

    public function save(BudgetItem $budgetItem)
    {
        if (is_string($this->expense_id)) $this->expense_id = $this->create()->id;
        $validated = $this->validate([
            'expense_id' => ['required', 'integer', 'exists:expenses,id'],
            'days' => ['nullable', 'integer', 'min:0'],
            'total' => ['required', 'integer', 'min:0'],
        ]);

        $budgetItem->budgetItemExpenses()->updateOrCreate(['expense_id' => $validated['expense_id']], $validated);
        $this->clear();
    }
}
