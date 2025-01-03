<?php

namespace App\Livewire\Forms;

use App\Models\BudgetItem;
use App\Models\BudgetItemExpense;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class BudgetExpenseForm extends Form
{
    public $expense, $total, $owner, $type, $days;

    private function create()
    {
        try {
            $this->expense = json_decode($this->expense)->value;
        } catch (\Throwable $th) {
            $this->reset('expense');
        }

        $validated = $this->validate(['expense' => ['required', 'string', 'min:6', 'max:255']]);
        $existingExpense = Expense::where('id', $validated['expense'])->orWhere('label', $validated['expense'])->first();
        if ($existingExpense) return $existingExpense;

        return Expense::create([
            'user_id' => Auth::user()->id,
            'label' => $validated['expense'],
        ]);
    }

    public function clear() {
        $this->reset();
    }

    public function submit(){
        if (!is_numeric($this->expense) && is_string($this->expense) && json_validate($this->expense)) {
            $created = $this->create();

            if ($created) $this->expense = $created->id;
        }

        $validated = $this->validate([
            'expense' => ['required', 'integer', 'exists:expenses,id'],
            'total' => ['required', 'numeric', 'min:1'],
            'owner' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $validated['expense_id'] = $validated['expense'];
        unset($validated['expense']);

        $this->reset();
        return $validated;
    }
}
