<?php

namespace App\Livewire\Invitations;

use App\Livewire\Forms\InvitationForm;
use App\Models\Invitation;
use Livewire\Attributes\On;
use Livewire\Component;

class Dialog extends Component
{
    public InvitationForm $invitation;

    public function onOpenDialog(Invitation $invitation) {
        $this->invitation->set($invitation);
    }

    #[On('onCloseModal')]
    public function onCloseModal() {
        $this->invitation->reset();
    }

    public function submit() {
        $invitation = null;
        if (empty($this->invitation->invitation)){
            $invitation = $this->invitation->store();
        }else{
            $invitation = $this->invitation->update();
        }

        $this->dispatch("alert", trans('invitations.alert-save', ['label' => $invitation->label]));
        $this->dispatch('close-modal', 'invitation-form');
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.invitations.dialog');
    }
}
