<?php

namespace App\Livewire\Offices;

use App\Livewire\Forms\OfficeForm;
use App\Models\Office;
use Livewire\Attributes\On;
use Livewire\Component;
use PA\ProvinceTh\Factory;

class Dialog extends Component
{
    public OfficeForm $office;
    public $provinces;

    public function onOpenDialog(Office $target) {
        $this->office->set($target);
    }

    #[On('onCloseModal')]
    public function onCloseModal() {
        $this->office->reset();
    }

    public function submit() {
        $office = null;
        if (empty($this->office->office)){
            $office = $this->office->store();
        }else{
            $office = $this->office->update();
        }

        $this->dispatch("alert", trans('offices.alert-save', ['label' => $office->label]));
        $this->dispatch('close-modal', 'office-form');
        $this->dispatch('refreshDatatable');
    }

    public function mount()
    {
        $this->provinces = Factory::province()->toArray();
    }

    public function render()
    {
        return view('livewire.offices.dialog');
    }
}
