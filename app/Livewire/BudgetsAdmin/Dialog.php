<?php

namespace App\Livewire\BudgetsAdmin;

use App\Livewire\Forms\BudgetForm;
use App\Models\Budget;
use App\Models\Invitation;
use App\Models\Office;
use App\Rules\UserRole;
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

    private function search(Budget $budget)
    {
        $budgetItemValue = ['budget_id' => $budget->id, 'user_id' => $budget->user_id];
        $budgetItem = $this->user_id ? (
            $budget->budgetItems()->where('user_id', $this->user_id)->first('id')
        ) : (
            $budget->budgetItems()->updateOrCreate($budgetItemValue, $budgetItemValue)
        );
        if ($budgetItem) return $this->view($budget->serial, $budgetItem->id);
        if (!$budgetItem && $this->user_id) return $this->addError('user_id', "ผู้ใช้งานนี้ไม่เกี่ยวข้องกับใบเบิกสัญญาที่ {$budget->serial}");
    }

    private function create(Budget $budget)
    {
        if (!$this->infoStep) return $this->infoStep = true;
        $validated = $this->validate([
            'user_id' => ['required', new UserRole("USER")],
            'serial' => $this->budgetForm->rules()['serial']
        ]);

        /* OVERRIDE */
        $this->budgetForm->serial = $validated['serial'];
        $budget->user_id = $validated['user_id'];

        $budget->fill($this->budgetForm->validate());
        $budget->save();
        $budgetItemValue = ['budget_id' => $budget->id, 'user_id' => $budget->user_id];
        $budgetItem = $budget->budgetItems()->updateOrCreate($budgetItemValue, $budgetItemValue);

        $this->clear();
        return $this->view($validated['serial'], $budgetItem->id);
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
