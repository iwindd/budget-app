<?php

namespace App\Livewire\Forms;

use App\Models\Budget;
use App\Models\Invitation;
use App\Models\Office;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class BudgetForm extends Form
{
    public ?Budget $budget;

    public $date;
    public $value;

    /* READONLY */
    public $serial;
    public $name;
    public $office;
    public $invitation;

    private function parseBudget(String $serial): Budget
    {
        $budget = Budget::where('serial', $serial)->first() ?? new Budget();
        if ($budget->exists) return $budget;
        /* FILL NEW BUDGET */
        $budget->serial        = $serial;
        $budget->user_id       = Auth::user()->id;
        $budget->office_id     = Office::getOffice('id')->id;
        $budget->invitation_id = Invitation::getInvitation('id')->id;
        return $budget;
    }

    public function setBudget(String $serial): Budget
    {
        $this->budget = $this->parseBudget($serial);
        /* FORMS */
        $this->date       = $this->budget->date;
        $this->value      = $this->budget->value;

        $this->serial     = $this->budget->serial;
        $this->name       = $this->budget->user->name;
        $this->office     = $this->budget->office->label;
        $this->invitation = $this->budget->invitation->label;

        return $this->budget;
    }

    public function save(): Budget
    {
        $validated = $this->validate();
        $budget = $this->parseBudget($validated['serial']);
        $budget->fill($validated);
        $budget->save();
        return $budget;
    }

    public function rules()
    {
        return [
            'serial' => ['required'],
            'date' => ['required'],
            'value' => ['required', 'integer']
        ];
    }
}
