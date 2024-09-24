<?php

namespace App\Livewire\Budgets;

use App\Models\Budget;
use App\Models\BudgetItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ExpensePatial extends Component
{
    /* DATA */
    public $budget;
    public $expenses = [];

    /* FORM */
    #[Validate('required|exists:expenses,id')]
    public $expense_id = '';

    #[Validate('nullable|integer')]
    public $days = '';

    #[Validate('required|integer')]
    public $total = '';

    /* CACHE */
    public $expense_label = '';

    /* ETC */
    protected $listeners = [
        'selectedExpense',
    ];

    public function mount(Request $request)
    {
        $this->budget = $request->route('budget');
        $this->fetch();
    }

    private function fetch()
    {
        $item = $this->getBudgetItem($this->budget);

        if ($item) $this->expenses = $item->expenses()->with('expense:label,id')->get()->toArray();
    }

    private function getBudgetItem(): BudgetItem | null
    {
        $budgetInstance = Budget::where('serial', $this->budget)->first();

        if (!$budgetInstance) {
            return null;
        };

        return $budgetInstance->budgetItems()->where('user_id', Auth::user()->id)->first();
    }

    public function save()
    {
        $validated = $this->validate();
        $validated['days'] = empty($validated['days']) ? null : $validated['days'];
        $item = $this->getBudgetItem();
        if (!$item) return $this->redirect('/');

        $item->expenses()->updateOrCreate(['expense_id' => $validated['expense_id']], $validated);
        $this->reset(['expense_id', 'days', 'total', 'expense_label']);
        $this->fetch();
    }

    public function removeExpense($id) {
        $item = $this->getBudgetItem();
        if (!$item) return $this->redirect('/');

        $item->expenses()->where('id', $id)->delete();
        $this->fetch();
    }

    public function render()
    {
        return view('livewire.budgets.expense-patial');
    }

    /* Listeners */

    public function selectedExpense($item, $text)
    {
        $this->expense_id = $item;
        $this->expense_label = $text;
    }
}