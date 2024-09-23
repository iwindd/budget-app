<?php

namespace App\Livewire\Budgets;

use App\Models\Budget;
use App\Rules\AlreadyCompanion;
use App\Rules\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CompanionPatial extends Component
{
    /* DATA */
    public $budget;
    public $companions = [];
    public $isOwner = false;

    /* FORM */
    public $user_id = '';

    /* ETC */
    protected $listeners = [
        'selectedCompanion',
    ];

    /* CACHE */
    public $user_label = '';

    public function mount(Request $request, $isOwner)
    {
        $this->budget = $request->route('budget');
        $this->isOwner = $isOwner;
        $this->fetch();
    }

    private function fetch()
    {
        $budget = $this->getBudget();

        if ($budget) $this->companions = $budget->budgetItems()->whereNot('user_id', $budget->user_id)->with("user")->get()->toArray();
    }

    private function getBudget(): Budget | null
    {
        return Budget::where('serial', $this->budget)->first();
    }

    public function save()
    {
        $validated = $this->validate();
        $budget = $this->getBudget();
        if (!$budget) return $this->redirect('/');
        if ($budget->user_id != Auth::user()->id) return $this->redirect('/');

        $budget->budgetItems()->create($validated);
        $this->reset(['user_id', 'user_label']);
        $this->fetch();

        return redirect()->back();
    }

    public function removeCompanion($id)
    {
        $budget = $this->getBudget();
        if (!$budget) return $this->redirect('/');
        if ($budget->user_id != Auth::user()->id) return $this->redirect('/');

        $budget->budgetItems()->where('id', $id)->delete();
        $this->fetch();
    }

    public function render()
    {
        return view('livewire.budgets.companion-patial');
    }

    public function rules() {
        return [
            'user_id' => ['required', new UserRole("USER"), new AlreadyCompanion($this->budget)]
        ];
    }

    /* Listeners */

    public function selectedCompanion($item, $text)
    {
        $this->user_id = $item;
        $this->user_label = $text;
    }
}
