<?php

namespace App\Livewire\Positions;

use App\Livewire\Forms\PositionForm;
use App\Models\Position;
use Livewire\Attributes\On;
use Livewire\Component;

class Dialog extends Component
{
    public PositionForm $position;

    public function onOpenDialog(Position $position) {
        $this->position->set($position);
    }

    #[On('onCloseModal')]
    public function onCloseModal() {
        $this->position->clear();
    }

    public function submit() {
        $position = null;
        if (empty($this->position->position)){
            $position = $this->position->store();
        }else{
            $position = $this->position->update();
        }

        $this->dispatch("alert", trans('positions.alert-save', ['label' => $position->label]));
        $this->dispatch('close-modal', 'position-form');
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.positions.dialog');
    }
}
