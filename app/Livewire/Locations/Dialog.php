<?php

namespace App\Livewire\Locations;

use App\Livewire\Forms\LocationForm;
use App\Models\Location;
use Livewire\Attributes\On;
use Livewire\Component;

class Dialog extends Component
{
    public LocationForm $location;

    public function onOpenDialog(Location $location) {
        $this->location->set($location);
    }

    #[On('onCloseModal')]
    public function onCloseModal() {
        $this->location->clear();
    }

    public function submit() {
        $location = null;
        if (empty($this->location->location)){
            $location = $this->location->store();
        }else{
            $location = $this->location->update();
        }

        $this->dispatch("alert", trans('locations.alert-save', ['label' => $location->label]));
        $this->dispatch('close-modal', 'location-form');
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.locations.dialog');
    }
}
