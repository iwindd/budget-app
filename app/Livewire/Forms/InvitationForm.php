<?php

namespace App\Livewire\Forms;

use App\Models\Invitation;
use Livewire\Form;

class InvitationForm extends Form
{
    public ?Invitation $invitation;
    public $label = '';
    public $default = false;

    public function set(Invitation $invitation) {
        $this->invitation = $invitation;
        $this->label = $invitation->label;
        $this->default = $invitation->default;
    }

    public function clear() {
        return $this->reset();
    }

    public function store()
    {
        $validated = $this->validate();
        if ($validated['default']) Invitation::deactivated();
        $invitation = Invitation::create($validated);
        $this->reset();
        return $invitation;
    }

    public function update()
    {
        $validated = $this->validate();
        $invitation = $this->invitation;
        if ($validated['default']) Invitation::deactivated();
        $this->invitation->update($validated);
        $this->reset();
        return $invitation;
    }

    public function rules() {
        return [
            'label' => ['required', 'string', 'min:6', 'max:255'],
            'default' => ['required', 'boolean'],
        ];
    }
}
