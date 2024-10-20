<?php

namespace App\Livewire\Forms;

use App\Models\Budget;
use App\Models\BudgetItem;
use App\Rules\AlreadyCompanion;
use App\Rules\UserRole;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class BudgetCompanionForm extends Form
{
    public $user_id;

    public function hasPermissionToManage(Budget $budget)
    {
        return $budget->user_id == Auth::user()->id;
    }

    private function getOriginalBudgetItem(Budget $budget): BudgetItem
    {
        return Budget::getOwnerBudget($budget);
    }

    public function clear()
    {
        $this->reset();
        $this->getComponent()->dispatch("onCompanionSelectorClear");
    }

    public function delete(BudgetItem $budgetItem)
    {
        if (!$this->hasPermissionToManage($budgetItem->budget)) return;
        $budgetItem->delete();
    }

    public function save(Budget $budget)
    {
        $validated = $this->validate([
            'user_id' => ['required', new UserRole("USER"), new AlreadyCompanion($budget->serial)]
        ]);

        if (!$this->hasPermissionToManage($budget)) return;
        $originalBudgetItem = $this->getOriginalBudgetItem($budget);
        if (!$originalBudgetItem) return;

        $values = $originalBudgetItem->only(['order', 'date', 'header', 'subject']) + $validated;
        $budget->budgetItems()->create($values);
        $this->clear();
    }
}
