<?php

namespace App\Livewire\Users;

use App\Models\Affiliation;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Dialog extends Component
{
    public ?User $user = null;
    public $name,
        $position,
        $affiliation,
        $role = 'user',
        $password,
        $password_confirmation,
        $email;

    public function onOpenDialog(User $user) {
        dd('open');
    }

    #[On('onCloseModal')]
    public function onCloseModal() {

    }

    public function rules(){
        return [
            'name' => ['required', 'string', 'min:6', 'max:255'],
            'position' => ['required', 'exists:positions,id'],
            'affiliation' => ['required', 'exists:affiliations,id'],
            'role' => ['required', 'string', 'in:user,admin,banned'],
            'password' => ['required', 'string','min:8', 'confirmed'],
            'password_confirmation' => ['required','string','min:8'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.($this->user ? $this->user->id : null)],
        ];
    }

    public function createPosition() {
        try {
            $this->position = json_decode($this->position)->value;

            $validated = $this->validate(['position' => ['required', 'string', 'min:6', 'max:255']]);
            $position = Position::where('id', $validated['position'])->orWhere('label', $validated['position'])->first();
            if ($position) return $position;
            return Position::create([
                'user_id' => Auth::user()->id,
                'label' => $validated['position'],
            ]);
        } catch (\Throwable $th) {
            $this->reset('position');
        }
    }

    public function createAffiliation() {
        try {
            $this->affiliation = json_decode($this->affiliation)->value;

            $validated = $this->validate(['affiliation' => ['required','string','min:6','max:255']]);
            $affiliation = Affiliation::where('id', $validated['affiliation'])->orWhere('label', $validated['affiliation'])->first();
            if ($affiliation) return $affiliation;
            return Affiliation::create([
                'user_id' => Auth::user()->id,
                'label' => $validated['affiliation'],
            ]);
        } catch (\Throwable $th) {
            $this->reset('affiliation');
        }
    }

    public function submit() {
        if (!is_numeric($this->position) && is_string($this->position) && json_validate($this->position)) {
            $created = $this->createPosition();

            if ($created) $this->position = $created->id;
        }

        if (!is_numeric($this->affiliation) && is_string($this->affiliation) && json_validate($this->affiliation)) {
            $created = $this->createAffiliation();

            if ($created) $this->affiliation = $created->id;
        }

        $validated = $this->validate();

        $validated['position_id'] = $validated['position'];
        $validated['affiliation_id'] = $validated['affiliation'];

        $user = User::create($validated);
        $this->reset();
        $this->dispatch("alert", trans('users.alert-add', ['label' => $user->label]));
        $this->dispatch('close-modal', 'users-form');
        $this->dispatch('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.users.dialog');
    }
}
