<?php

namespace App\Livewire\BudgetsAdmin;

use App\Livewire\Forms\BudgetForm;
use App\Models\Budget;
use App\Models\Invitation;
use App\Models\Office;
use Livewire\Component;

class Dialog extends Component
{
    public BudgetForm $budgetForm;
    public $serial = null;
    public $infoStep = false;
    public $user_id;

    public function mount()
    {
        $this->budgetForm->setBudget(new Budget());
    }

    public function clear()
    {
        $this->dispatch("onUserSelectorClear");
        $this->reset(['serial', 'user_id']);
        $this->budgetForm->reset(['serial', 'date', 'value']);
        $this->infoStep = false;
    }

    public function view($serial, $budgetItemId)
    {
        return $this->redirectRoute('budgets.show.admin', [
            'budget' => $serial,
            'budgetItem' => $budgetItemId
        ]);
    }

    public function submit()
    {
        $validated = $this->validate([
            'serial' => $this->budgetForm->rules()['serial'],
            'user_id' => ['required', 'exists:users,id']
        ]);

        $budget = Budget::where($validated)->first();

        if (!$budget){
            $validated['invitation_id'] = Invitation::getInvitation(['id'])->id;
            $validated['office_id'] = Office::getOffice(['id'])->id;
            $budget = Budget::create($validated);
        }

        $this->redirectRoute('budgets.show.admin', ['budget' => $budget->id]);
    }

    public function render()
    {
        return view('livewire.budgets-admin.dialog');
    }
}
