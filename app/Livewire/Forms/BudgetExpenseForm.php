<?php

namespace App\Livewire\Forms;

use App\Models\BudgetItem;
use App\Models\BudgetItemExpense;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class BudgetExpenseForm extends Form
{
    public $expense, $total;

    private function create()
    {
        $validated = $this->validate(['expense' => ['required', 'string', 'max:255']]);

        return Expense::firstOrCreate(['label' => $validated['expense']],[
            'user_id' => Auth::user()->id,
            'label' => $validated['expense'],
            'merge' => true,
            'default' => false
        ]);
    }

    public function submit(){
        if (is_string($this->expense)) {
            $this->expense = $this->create()->id;
        }

        $validated = $this->validate([
            'expense' => ['required', 'integer', 'exists:expenses,id'],
            'total' => ['required', 'integer', 'min:0'],
        ]);

        $validated['expense_id'] = $validated['expense'];
        unset($validated['expense']);

        $this->reset();
        return $validated;
    }
}
