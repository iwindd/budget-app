<?php

namespace App\Livewire\Affiliations;

use App\Livewire\Forms\AffiliationForm;
use App\Models\Affiliation;
use Livewire\Attributes\On;
use Livewire\Component;

class Dialog extends Component
{
    public AffiliationForm $affiliation;

    public function onOpenDialog(Affiliation $affiliation) {
        $this->affiliation->set($affiliation);
    }

    #[On('onCloseModal')]
    public function onCloseModal() {
        $this->affiliation->clear();
    }

    public function submit() {
        $affiliation = null;
        if (empty($this->affiliation->affiliation)){
            $affiliation = $this->affiliation->store();
        }else{
            $affiliation = $this->affiliation->update();
        }

        $this->dispatch("alert", trans('affiliations.alert-save', ['label' => $affiliation->label]));
        $this->dispatch('close-modal', 'affiliation-form');
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.affiliations.dialog');
    }
}
