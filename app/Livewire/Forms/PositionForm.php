<?php

namespace App\Livewire\Forms;

use App\Models\Position;
use Illuminate\Support\Facades\Auth;
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
       /** @var User $user */
        $user = Auth::user();
        $validated = $this->validate();
        $position =  $user->positions()->create($validated);
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
