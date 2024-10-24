<?php

namespace App\Livewire\Forms;

use App\Models\Location;
use Livewire\Form;

class LocationForm extends Form
{
    public ?Location $location;
    public $label = '';

    public function set(Location $location)
    {
        $this->location = $location;
        $this->label = $location->label;
    }

    public function clear()
    {
        return $this->reset();
    }

    public function store()
    {
        $validated = $this->validate();
        $location = Location::create($validated);
        $this->clear();

        return $location;
    }

    public function update()
    {
        $validated = $this->validate();
        $location = $this->location;
        $this->location->update($validated);
        $this->clear();

        return $location;
    }

    public function rules()
    {
        return [
            'label' => ['required', 'string', 'min:6', 'max:255'],
        ];
    }
}
