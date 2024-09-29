<?php

namespace App\Livewire\BudgetsAdmin;

use App\Models\Budget;
use App\Models\Invitation;
use App\Models\Office;
use App\Rules\UserRole;
use Livewire\Component;

class Dialog extends Component
{
    /* DATA */
    public $isNew = false;

    /* FROM */
    public $serial;
    public $user_id;
    public $value;
    public $order_id;
    public $subject; #

    /* ETC */
    protected $listeners = [
        'selectedUser',
    ];

    /* CACHE */
    public $user_label = '';

    public function clear()
    {
        $this->isNew = false;
        $this->reset(['serial', 'value', 'order_id', 'subject']);
    }

    public function search()
    {
        $validated = $this->validate([
            'serial' => ['required', 'string', 'max:255'],
        ]);

        $budget = Budget::where($validated)->first();

        if ($budget) {
            $this->redirectRoute('budgets.show.admin', [
                'budget' => Budget::getOwnerBudget($budget)
            ]);
        }
        $this->isNew = true;
    }

    public function save()
    {
        $validated = $this->validate();
        $validated['office_id']     = Office::getOffice('id')->id;
        $validated['invitation_id'] = Invitation::getInvitation('id')->id;
        $validated['date'] = now();
        $validated['order_at'] = $validated['date'];

        $budget = Budget::updateOrCreate([
            'serial' => $validated['serial'],
            'user_id' => $validated['user_id']
        ], $validated);

        if ($budget->wasRecentlyCreated) {
            $item = $budget->budgetItems()->create(['user_id' => $validated['user_id']]);
            $this->redirectRoute('budgets.show.admin', ['budget' => $item]);
        } else {
            $this->redirectRoute('budgets.show.admin', ['budget' => Budget::getOwnerBudget($budget)]);
        }
    }

    public function submit()
    {
        return $this->isNew ? $this->save() : $this->search();
    }

    public function render()
    {
        return view('livewire.budgets-admin.dialog');
    }

    public function rules()
    {
        return [
            'user_id' => ['required', new UserRole("USER")],
            'serial' => ['required', 'string', 'max:255'],
            'value' => ['required', 'integer'],
            'order_id' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255']
        ];
    }

    /* Listeners */

    public function selectedUser($item, $text)
    {
        $this->user_id = $item;
        $this->user_label = $text;
    }
}
