<?php

namespace App\Livewire\Forms;

use App\Models\Affiliation;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class AffiliationForm extends Form
{
    public ?Affiliation $affiliation;
    public $label = '';

    public function set(Affiliation $affiliation)
    {
        $this->affiliation = $affiliation;
        $this->label = $affiliation->label;
    }

    public function clear()
    {
        return $this->reset();
    }

    public function store()
    {
        /** @var User $user */
        $user = Auth::user();
        $validated = $this->validate();
        $affiliation = $user->affiliations()->create($validated);
        $this->clear();

        return $affiliation;
    }

    public function update()
    {
        $validated = $this->validate();
        $affiliation = $this->affiliation;
        $this->affiliation->update($validated);
        $this->clear();

        return $affiliation;
    }

    public function rules()
    {
        return [
            'label' => ['required', 'string', 'min:6', 'max:255'],
        ];
    }
}
