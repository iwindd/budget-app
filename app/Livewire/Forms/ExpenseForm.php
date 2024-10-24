<?php

namespace App\Livewire\Forms;

use App\Models\Expense;
use Livewire\Form;

class ExpenseForm extends Form
{
    public ?Expense $expense;
    public $label = '';
    public $default = false;
    public $merge = true;

    public function set(Expense $expense) {
        $this->expense = $expense;
        $this->label = $expense->label;
        $this->default = $expense->default;
        $this->merge = $expense->merge;
    }

    public function clear() {
        return $this->reset();
    }

    public function store()
    {
        $validated = $this->validate();
        if ($validated['default']) Expense::deactivated();
        $expense = Expense::create($validated);
        $this->clear();

        return $expense;
    }

    public function update()
    {
        $validated = $this->validate();
        $expense = $this->expense;
        if ($validated['default']) Expense::deactivated();
        $this->expense->update($validated);
        $this->clear();

        return $expense;
    }

    public function rules() {
        return [
            'label' => ['required', 'string', 'min:6', 'max:255'],
            'default' => ['required', 'boolean'],
            'merge' => ['required', 'boolean'],
        ];
    }
}
