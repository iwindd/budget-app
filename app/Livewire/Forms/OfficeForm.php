<?php

namespace App\Livewire\Forms;

use App\Models\Office;
use Livewire\Attributes\Validate;
use Livewire\Form;

class OfficeForm extends Form
{
    public ?Office $office;

    #[Validate('required|string|min:6|max:100')]
    public $label = '';

    #[Validate('required|integer')]
    public $province = 67;

    #[Validate('required|boolean')]
    public $default = false;

    public function set(Office $office) {
        $this->office = $office;
        $this->label = $office->label;
        $this->province = $office->province;
        $this->default = $office->default;
    }

    public function store()
    {
        $validated = $this->validate();
        $office = Office::create($validated);
        if ($validated['default']) Office::setActive($office);
        $this->reset();
        return $office;
    }

    public function update()
    {
        $validated = $this->validate();
        $office = $this->office;
        $this->office->update($validated);
        if ($validated['default']) Office::setActive($office);
        $this->reset();
        return $office;
    }
}
