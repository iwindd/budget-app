<?php

namespace App\Livewire\Forms;

use App\Models\BudgetItem;
use App\Models\BudgetItemExpense;
use Livewire\Form;

class BudgetItemExpenseForm extends Form
{
    //
    public $expense_id;
    public $days;
    public $total;

    public function clear() {
        $this->reset();
        $this->getComponent()->dispatch("onExpenseSelectorClear");
    }

    public function delete(BudgetItemExpense $budgetItemExpense) {
        $budgetItemExpense->delete();
    }

    public function save(BudgetItem $budgetItem)
    {
        $validated = $this->validate([
            'expense_id' => ['required', 'integer', 'exists:expenses,id'],
            'days' => ['nullable', 'integer', 'min:0'],
            'total' => ['required', 'integer', 'min:0'],
        ]);

        $budgetItem->budgetItemExpenses()->updateOrCreate(['expense_id' => $validated['expense_id']], $validated);
        $this->clear();
    }
}
