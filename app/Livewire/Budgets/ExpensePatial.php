<?php

namespace App\Livewire\Budgets;

use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Ramsey\Uuid\Type\Integer;

class ExpensePatial extends Component
{
    /* DATA */
    public $budget;
    public $user;
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
        $isAdminBudget = request()->routeIs('budgets.show.admin');
        $key = $request->route('budget');
        $this->user = !$isAdminBudget ? Auth::user() : $key->user;
        $this->budget = !$isAdminBudget ? Budget::getUserBudgetBySerial($key, $this->user->id) : $key;
        $this->fetch();
    }

    private function fetch()
    {
        $this->expenses = $this->budget->budgetItemExpenses()->with('expense:label,id')->get()->toArray();
    }

    private function clear(){
        $this->reset(['expense_id', 'days', 'total', 'expense_label']);
    }

    public function addExpense(String $label) : int  {
        $sameExpense = Expense::where('label', $label)->first(['id', 'label']);
        if ($sameExpense) return $sameExpense->id;

        /** @var User $user */
        $user = Auth::user();
        $newExpense = $user->budgetItemExpenses()->create([
            'label' => $label
        ]);

        return $newExpense->id;
    }

    public function removeExpense($id) {
        $this->budget->budgetItemExpenses()->find($id)->delete();
        $this->fetch();
    }

    public function save()
    {
        if (gettype($this->expense_id) == "string") {
            $this->expense_id = $this->addExpense($this->expense_id);
        }

        $validated = $this->validate();
        $validated['days'] = empty($validated['days']) ? null : $validated['days'];

        $this->budget->budgetItemExpenses()->updateOrCreate(['expense_id' => $validated['expense_id']], $validated);
        $this->clear();
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
