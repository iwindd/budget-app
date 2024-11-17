<?php

namespace App\Livewire\Budgets;

use App\Livewire\Forms\BudgetAddressForm;
use App\Livewire\Forms\BudgetExpenseForm;
use App\Livewire\Forms\BudgetForm;
use App\Models\Budget;
use App\Models\BudgetAddress;
use App\Models\BudgetItem;
use App\Models\BudgetItemExpense;
use App\Models\Expense;
use App\Models\Invitation;
use App\Models\Office;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BudgetPartial extends Component
{
    public BudgetForm $budgetForm;
    public BudgetAddressForm $budgetAddressForm;
    public BudgetExpenseForm $budgetExpenseForm;

    public $hasPermissionToManage = false;
    public $addressSelectize = [];

    public $companions = [];
    public $addresses  = [];
    public $expenses   = [];

    public function mount(Request $request)
    {
        $this->addressSelectize = BudgetAddress::list()->toArray();
        $staticExpenses    = Expense::getStaticExpenses();
        $payloadExpenses = collect([]);
        $budget = $this->budgetForm->setBudget($request->budget);

        if ($budget->exists) {
            $this->addresses = $budget->addresses()->get(['from_id', 'from_date', 'back_id', 'back_date', 'multiple', 'plate', 'distance'])->toArray();
            $this->companions = $budget->companions()->pluck('user_id');
            $payloadExpenses = $budget->expenses()->get()->map(function ($expense) {
                return [
                    'days' => $expense->days,
                    'total' => $expense->total,
                ] + $expense->expense->toArray();
            });
        }

        $this->hasPermissionToManage = !$budget->exists || $budget->user_id == Auth::user()->id;

        $staticExpenses->map(function($expense) use (&$payloadExpenses){
            if (!$payloadExpenses->firstWhere('id', $expense['id'])){
                $payloadExpenses->push([
                    'days' => $expense->split ? $expense->days : null,
                    'total' => '',
                ]+ $expense->toArray());
            }
        });

        $this->expenses = $payloadExpenses->toArray();
    }

    public function rules() {
        return [
            'companions' => ['array'],
            'companions.*' => ['integer'],
            'addresses' => ['array'],
            'addresses.*.from_id' => ['required', 'integer'],
            'addresses.*.back_id' => ['required', 'integer'],
            'addresses.*.from_date' => ['required', 'date', 'date_format:Y-m-d H:i'],
            'addresses.*.back_date' => ['required', 'date', 'date_format:Y-m-d H:i', 'after_or_equal:addresses.*.from_date'],
            'addresses.*.multiple' => ['required', 'boolean'],
            'addresses.*.plate' => ['required', 'string'],
            'addresses.*.distance' => ['required', 'integer'],
            'expenses' => ['array'],
            'expenses.*.id' => ['required', 'exists:expenses,id'], // this is expense id, not budgetExpense.id
            'expenses.*.days' => ['nullable', 'integer', 'min:1'],
            'expenses.*.total' => ['required', 'integer', 'min:1'],
            'expenses.*.split' => ['boolean']
        ];
    }

    public function save()
    {
        if (!$this->hasPermissionToManage) return false;
        $this->addresses = collect($this->addresses)->map(fn ($address) =>[
            'from_date' => Carbon::parse($address['from_date'])->format('Y-m-d H:i'),
            'back_date' => Carbon::parse($address['back_date'])->format('Y-m-d H:i')
        ] + $address)->sortBy('from_date')->toArray();
        $this->budgetAddressForm->clear();
        $this->budgetExpenseForm->clear();
        $validated = $this->validate();

        // validation etc
        Carbon::setLocale('th');
        $lastEvent        = Carbon::parse(collect($validated['addresses'])->last()['back_date']);
        $lastEventRange   = $lastEvent->clone()->addMonth();
        $finish_at        = Carbon::parse($validated['finish_at']);
        $hasCustomError   = false;

        if (!$finish_at->between($lastEvent, $lastEventRange)){
            $lastEventFormatted = $lastEvent->translatedFormat('j M y H:i');
            $lastEventRangeFormatted = $lastEventRange->translatedFormat('j M y H:i');

            $this->addError('budgetForm.finish_at', "ลงวันที่จำเป็นต้องอยู่ระหว่างหลังการสิ้นสุดการเดินทาง 30 วัน หรือระหว่าง {$lastEventFormatted} - {$lastEventRangeFormatted}");
            $hasCustomError = true;
        }

        $totalAmount = collect($validated['expenses'])->map(function ($expense) {
            return $expense['split'] && $expense['days'] ? $expense['total'] * $expense['days'] : $expense['total'];
        })->sum();

        if ($validated['value'] < $totalAmount){
            $formatTotal = number_format($totalAmount);
            $this->addError('budgetForm.value', "จำนวนเงินที่ต้องการเบิกน้อยกว่ารายการค่าใช้จ่ายทั้งหมดซึ่งมีมูลค่า {$formatTotal}บาท");
            $hasCustomError = true;
        }
        
        if ($hasCustomError) {
            $this->dispatch("alert", trans('budgets.alert-budget-error'));
            return false;
        }

        // etc
        $budget = $this->budgetForm->budget;
        $exists = $budget->exists;

        // fill another fields;
        $validated['user_id'] = $exists ? $budget->user_id : Auth::user()->id;
        $validated['invitation_id'] = $budget->invitation ? $budget->invitation->id : Invitation::getInvitation('id')->id;
        $validated['office_id'] = $budget->office ? $budget->office->id : Office::getOffice('id')->id;

        // save budget
        $budget->fill($validated);
        $budget->save();

        // update companions
        $currentCompanions = $exists ? $budget->companions()->pluck('user_id') : collect([]);
        $newCompanions     = collect($validated['companions']);

        $companionsToAdd   = $newCompanions->diff($currentCompanions);
        $companionsToRemove = $currentCompanions->diff($newCompanions);

        $budget->companions()->whereIn('user_id', $companionsToRemove)->delete();
        $budget->companions()->createMany($companionsToAdd->map(fn($companion) => ['user_id' => $companion])->all());

        // update addresses
        $budget->addresses()->delete();
        $budget->addresses()->createMany($validated['addresses']);

        // update expenses
        $budget->expenses()->delete();
        $budget->expenses()->createMany(collect($validated['expenses'])->map(fn($expense) => [
            'expense_id' => $expense['id'],
            'days' => $expense['split'] ? $expense['days'] : null,
            'total' => $expense['total']
        ])->toArray());

        // etc
        $this->dispatch("alert", trans('budgets.alert-budget-saved'));
    }

    public function render()
    {
        return view('livewire.budgets.index');
    }

    /* EXPENSE */
    public function onAddExpense() {
        if (!$this->hasPermissionToManage) return false;
        $validated = $this->budgetExpenseForm->submit();
        $expense   = Expense::find($validated['expense_id']);

        if (!$expense) return;
        if ($expense->static) return;
        if ($expense->default) return;

        $payload = collect($this->expenses);
        $expenseIndex = $payload->search(fn($item) => $item['id'] === $validated['expense_id']);

        if ($expenseIndex !== false) {
            $payload = $payload->map(function ($item, $key) use ($validated, $expenseIndex) {
                if ($key === $expenseIndex) $item['total'] = $validated['total'];
                return $item;
            });
        } else {
            $payload->push(array_merge($expense->toArray(), ['days' => null, 'total' => $validated['total']]));
        }

        $this->expenses = $payload->toArray();
    }

    public function onRemoveExpense($id) {
        if (!$this->hasPermissionToManage) return false;

        $this->expenses = collect($this->expenses)
            ->filter(fn($e) => $e['id'] != $id)
            ->toArray();
    }
}
