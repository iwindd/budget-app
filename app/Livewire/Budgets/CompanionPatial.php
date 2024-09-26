<?php

namespace App\Livewire\Budgets;

use App\Models\Budget;
use App\Rules\AlreadyCompanion;
use App\Rules\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CompanionPatial extends Component
{
    /* DATA */
    public $budget;
    public $user;
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
        $isAdminBudget = request()->routeIs('budgets.show.admin');
        $key = $request->route('budget');
        $this->budget = !$isAdminBudget ? Budget::where('serial', $key)->first() : $key->budget;
        if (!$this->budget) return $this->redirect('/');

        $this->user    = !$isAdminBudget ? Auth::user() : $key->user;
        $this->isOwner = $isOwner;
        $this->fetch();
    }

    private function fetch()
    {
        $this->companions = $this->budget->budgetItems()
            ->whereNot('user_id', $this->user->id)
            ->with(["user:id,name", "addresses:budget_item_id,from_date,back_date", "expenses:budget_item_id,total,days"])
            ->get(['id', 'budget_id', 'user_id'])
            ->toArray();

        foreach ($this->companions as $index => $companion) {
            $totalExpenseSum = 0;
            foreach ($companion['expenses'] as $expense) $totalExpenseSum += ($expense['total'] * ($expense['days'] ?? 1));
            $this->companions[$index]['expense_sum'] = $totalExpenseSum;

            if (count($companion['addresses']) > 0){
                $start = $companion['addresses'][0]['from_date'];
                $end = $companion['addresses'][count($companion['addresses'])-1]['back_date'];

                $startDate = Carbon::parse($start);
                $endDate = Carbon::parse($end);

                $this->companions[$index]['date_diff'] = $endDate->diffInDays($startDate);
            }

            $this->companions[$index]['isCreator'] = $this->budget->user_id == $companion['user_id'];
        }
    }

    public function save()
    {
        $validated = $this->validate();
        if (!$this->isOwner) return $this->redirect('/');

        $this->budget->budgetItems()->create($validated);
        $this->reset(['user_id', 'user_label']);
        $this->fetch();

        return redirect()->back();
    }

    public function removeCompanion($id)
    {
        if (!$this->isOwner) return $this->redirect('/');

        $this->budget->budgetItems()->where('id', $id)->delete();
        $this->fetch();
    }

    public function render()
    {
        return view('livewire.budgets.companion-patial');
    }

    public function rules() {
        return [
            'user_id' => ['required', new UserRole("USER"), new AlreadyCompanion($this->budget->serial)]
        ];
    }

    /* Listeners */

    public function selectedCompanion($item, $text)
    {
        $this->user_id = $item;
        $this->user_label = $text;
    }
}
