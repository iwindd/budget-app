<?php

namespace App\Livewire\Forms;

use App\Models\Position;
use Livewire\Form;

class PositionForm extends Form
{
    public ?Position $position;
    public $label = '';

    public function set(Position $position)
    {
        $this->position = $position;
        $this->label = $position->label;
    }

    public function clear()
    {
        return $this->reset();
    }

    public function store()
    {
        $validated = $this->validate();
        $position = Position::create($validated);
        $this->clear();

        return $position;
    }

    public function update()
    {
        $validated = $this->validate();
        $position = $this->position;
        $this->position->update($validated);
        $this->clear();

        return $position;
    }

    public function rules()
    {
        return [
            'label' => ['required', 'string', 'min:6', 'max:255'],
        ];
    }
}
