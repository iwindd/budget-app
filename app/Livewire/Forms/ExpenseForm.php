<?php

namespace App\Livewire\Forms;

use App\Models\Expense;
use Livewire\Form;

class ExpenseForm extends Form
{
    public ?Expense $expense;
    public $label = '';

    public function set(Expense $expense) {
        $this->expense = $expense;
        $this->label = $expense->label;
    }

    public function clear() {
        return $this->reset();
    }

    public function store()
    {
        $validated = $this->validate();
        $expense = Expense::create($validated);
        $this->clear();

        return $expense;
    }

    public function update()
    {
        $validated = $this->validate();
        $expense = $this->expense;
        $this->expense->update($validated);
        $this->clear();

        return $expense;
    }

    public function rules() {
        return [
            'label' => ['required', 'string', 'min:6', 'max:255']
        ];
    }
}
