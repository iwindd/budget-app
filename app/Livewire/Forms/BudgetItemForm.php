<?php

namespace App\Livewire\Forms;

use App\Models\Budget;
use App\Models\BudgetItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class BudgetItemForm extends Form
{
    public ?BudgetItem $budgetItem;

    public $order;
    public $date;
    public $header;
    public $subject;

    /* READONLY */
    public $name;
    public $position;
    public $affiliation;

    public function parseBudgetItem(Budget $budget): BudgetItem
    {
        // ** parseBudgetItem เมื่อใช้ตอน save จะไม่มี request เพราะจะยิงมาจาก url ของ livewire
        // ซึ่งทำให้ return new BudgetItem

        // * parameter budgetItem จาก request จะมีเฉพาะ request ของ admin
        $budgetItem  = (
            request()->budgetItem ? BudgetItem::find(request()->budgetItem) : $budget->budgetItems->where('user_id', Auth::user()->id)->first()
        ) ?? new BudgetItem();

        if (!$budgetItem->exists) $budgetItem->user_id = Auth::user()->id;
        if ($budget->exists) $budgetItem->budget_id = $budget->id;

        return $budgetItem;
    }

    public function setBudgetItem(BudgetItem $budgetItem)
    {
        $this->budgetItem = $budgetItem;
        /* FORMS */
        $this->order       = $this->budgetItem->order;
        $this->date        = $this->budgetItem->date;
        $this->header      = $this->budgetItem->header;
        $this->subject     = $this->budgetItem->subject;

        $this->name        = $this->budgetItem->user->name;
        $this->position    = $this->budgetItem->user->position->label;
        $this->affiliation = $this->budgetItem->user->affiliation->label;
    }

    public function save(Budget $budget)
    {
        $validated = $this->validate();
        $budgetItem = $this->budgetItem;
        if (!$budgetItem->exists) {
            $budgetItem = $this->parseBudgetItem($budget);
        }
        $budgetItem->fill($validated);
        $budgetItem->save();
    }

    public function exists()
    {
        return $this->budgetItem && $this->budgetItem->exists;
    }

    public function rules()
    {
        return [
            'order' => ['required', 'string', 'max:255'],
            'date' => ['required'],
            'header' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255']
        ];
    }
}
