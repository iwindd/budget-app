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

    private function disableDefault(){
        Office::where('default', true)->update(['default' => false]);
    }

    public function set(Office $office) {
        $this->office = $office;
        $this->label = $office->label;
        $this->province = $office->province;
        $this->default = $office->default;
    }

    public function store()
    {
        $validated = $this->validate();
        if ($validated['default']) $this->disableDefault();
        Office::create($validated);
        $this->reset();
    }

    public function update()
    {
        $validated = $this->validate();
        if ($validated['default']) $this->disableDefault();
        $this->office->update($validated);
        $this->reset();
    }
}
