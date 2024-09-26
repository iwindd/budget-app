<?php

namespace App\Livewire\Budgets;

use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\Invitation;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BudgetPatial extends Component
{
    /* DATA */
    public $user;
    public $isOwner;

    /* FROM DATA */
    public $serial;
    public $office;
    public $invitation;
    public $name;

    /* FROM */
    public $date;
    public $value;
    public $order_at;
    public $title;
    public $place;

    public function mount(Request $request)
    {
        $isAdminBudget = request()->routeIs('budgets.show.admin');
        $key = $request->route('budget');
        $data = !$isAdminBudget ? (
            Budget::where('serial', $key)
                ->with(['user', 'office', 'invitation'])
                ->first()
        ) : $key->budget;

        $this->user = !$isAdminBudget ? Auth::user() : $data->user;
        $this->serial = $data->serial;
        $this->isOwner = !$data || $data->user_id == $this->user->id || $isAdminBudget;
        $this->office     = ($data->office ?? Office::getOffice('label'))->label;
        $this->invitation = ($data->invitation ?? Invitation::getInvitation('label'))->label;
        $this->name       = ($data->user ?? $this->user)->name;

        $this->date     = $data->date ?? '';
        $this->value    = $data->value ?? '';
        $this->order_at = $data->order_at ?? '';
        $this->title    = $data->title ?? '';
        $this->place    = $data->place ?? '';
    }

    public function save()
    {
        $validated = $this->validate();
        $validated['office_id']     = Office::getOffice('id')->id;
        $validated['invitation_id'] = Invitation::getInvitation('id')->id;

        $budget = $this->user->budgets()->updateOrCreate(['serial' => $validated['serial']], $validated);
        if ($budget->wasRecentlyCreated) $budget->budgetItems()->create(['user_id' => $this->user->id]);
        if ($budget->wasRecentlyCreated) $this->js('window.location.reload()');
    }

    public function rules()
    {
        return [
            'serial' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string'],
            'place' => ['required', 'string'],
            'date' => ['required'],
            'value' => ['required', 'integer'],
            'order_at' => ['required'],
        ];
    }

    public function render()
    {
        return view('livewire.budgets.budget-patial');
    }
}
