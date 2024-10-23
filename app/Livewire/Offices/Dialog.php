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

    #[On('OpenOfficeDialog')]
    public function onOpenDialog(Office $target) {
        $this->office->set($target);
        $this->dispatch('open-modal', 'office-form');
        $this->dispatch('setProvince', $target->province);
    }

    #[On('onCloseModal')]
    public function onCloseModal() {
        $this->office->reset();
    }

    public function submit() {
        if (empty($this->office->office)){
            $this->office->store();
        }else{
            $this->office->update();
        }

        $this->redirectRoute('offices');
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
