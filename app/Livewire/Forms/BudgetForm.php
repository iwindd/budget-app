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
    public $serial,
        $finish_at,
        $value,
        $order,
        $date,
        $header,
        $subject,
        $addresses = [],
        $name,
        $position,
        $affiliation;
    public $invitation,
        $office,
        $companions; // เอาไว้ init selectize

    public function setBudget(Budget $budget) : Budget
    {
        $this->budget     = $budget;

        $this->serial = $budget->serial;
        $this->finish_at = $budget->finish_at;
        $this->value = $budget->value;
        $this->order = $budget->order;
        $this->date = $budget->date;
        $this->header = $budget->header;
        $this->subject = $budget->subject;
        $this->addresses = $budget->exists ? json_decode($budget->addresses) : [];
        $this->invitation = ($budget->exists ? ($budget->invitation->label  ?? 'N/A') : (Invitation::getInvitation('label')->label) ?? 'N/A');
        $this->office     = ($budget->exists ? ($budget->office->label      ?? 'N/A') : (Office::getOffice('label')->label)         ?? 'N/A');
        $user       = $budget->exists ? $budget->user : Auth::user();

        $this->name        = $user->name;
        $this->position    = $user->position->label;
        $this->affiliation = $user->affiliation->label;

        $this->companions = $budget->companions()
            ->with('user')
            ->get()
            ->map(function ($companion) {
                return [
                    'name' => $companion->user->name,
                    'id' => $companion->user->id,
                    'selected'=> true
                ];
            })
            ->toArray();
        return $budget;
    }

    public function save(): Budget
    {
        $validated = $this->validate();

        dd($validated);
        /* $budget = $this->budget;
        if (!$budget->exists){
            $budget = $this->parseBudget($this->serial);
        }
        $budget->fill($validated);
        $budget->save(); */
        return $budget;
    }

    public function exists() {
        return $this->budget && $this->budget->exists;
    }

    public function rules()
    {
        return [
            'serial' => ['required', 'string'],
            'finish_at' => ['required', 'date', 'date_format:Y-m-d'],
            'value' => ['required', 'numeric', 'min:50'],
            'order' => ['required', 'string'],
            'date' => ['required', 'date', 'date_format:Y-m-d'],
            'header' => ['required', 'string'],
            'subject' => ['required', 'string'],
        ];
    }
}
