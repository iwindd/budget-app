<?php

namespace App\Livewire\Forms;

use App\Models\Affiliation;
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
        $validated = $this->validate();
        $affiliation = Affiliation::create($validated);
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
