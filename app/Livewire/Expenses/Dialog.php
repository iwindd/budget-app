<?php

namespace App\Livewire\Expenses;

use App\Livewire\Forms\ExpenseForm;
use App\Models\Expense;
use Livewire\Attributes\On;
use Livewire\Component;

class Dialog extends Component
{
    public ExpenseForm $expense;

    public function onOpenDialog(Expense $expense) {
        $this->expense->set($expense);
    }

    #[On('onCloseModal')]
    public function onCloseModal() {
        $this->expense->clear();
    }

    public function submit() {
        $expense = null;
        if (empty($this->expense->expense)){
            $expense = $this->expense->store();
        }else{
            $expense = $this->expense->update();
        }

        $this->dispatch("alert", trans('expenses.alert-save', ['label' => $expense->label]));
        $this->dispatch('close-modal', 'expense-form');
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.expenses.dialog');
    }
}
