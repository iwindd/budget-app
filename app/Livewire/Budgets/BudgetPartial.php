<?php

namespace App\Livewire\Budgets;

use App\Livewire\Forms\BudgetAddressForm;
use App\Livewire\Forms\BudgetExpenseForm;
use App\Livewire\Forms\BudgetForm;
use App\Models\BudgetAddress;
use App\Models\Expense;
use App\Models\Invitation;
use App\Models\Office;
use App\Models\User;
use App\Rules\ValidUserId;
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
    public $addressEditing = null;

    public $companions;
    public $addresses  = [];
    public $expenses   = [];

    public $client_name,
            $client_position,
            $client_affiliation;

    public function mount(Request $request)
    {
        /** @var User $session */
        $budget = $request->budget;
        $session = Auth::user();
        $this->addressSelectize = BudgetAddress::list()->toArray();

        $this->budgetForm->setBudget($budget);
        $this->addresses = $budget->addresses->toArray();
        $this->companions = $budget->companions->pluck('user_id');
        $this->expenses  = $this->budgetForm->getExpenses();
        $this->hasPermissionToManage = $budget->user_id == $session->id || $session->role == 'admin';
        if ($this->hasPermissionToManage) $session = $budget->user;

        $this->client_name = $session->name;
        $this->client_position = $session->position->label;
        $this->client_affiliation = $session->affiliation->label;

        $companionPayload = collect($this->budgetForm->companions)->filter(fn($c) => $c['id'] != $session->id);
        $companionPayload->prepend([
            'id' => $session->id,
            'name' => $session->name,
            'selected' => true,
            'owner' => true
        ]);

        $this->budgetForm->companions = $companionPayload->toArray();
    }

    public function rules() {
        $related = array_merge($this->companions->toArray(), [$this->budgetForm->budget->user_id]);

        return [
            'companions' => ['array'],
            'companions.*' => ['integer'],
            'addresses' => ['array', 'min:1'],
            'addresses.*.from_id' => ['required', 'integer'],
            'addresses.*.back_id' => ['required', 'integer'],
            'addresses.*.from_date' => ['required', 'date', 'date_format:Y-m-d H:i'],
            'addresses.*.back_date' => ['required', 'date', 'date_format:Y-m-d H:i', 'after_or_equal:addresses.*.from_date'],
            'addresses.*.multiple' => ['required', 'boolean'],
            'addresses.*.plate' => ['required', 'string'],
            'addresses.*.distance' => ['required', 'numeric'],
            'addresses.*.show_as' => ['required', 'string'],
            'expenses' => ['array', 'min:1'],
            'expenses.*.id' => ['required', 'exists:expenses,id'],
            'expenses.*.type' => ['nullable', 'max:255'],
            'expenses.*.days' => ['nullable', 'integer', 'min:1'],
            'expenses.*.total' => ['required', 'numeric', 'min:1'],
            'expenses.*.user_id' => ['required', 'integer', new ValidUserId($related), 'exists:users,id'],
        ];
    }

    public function saveValidate() {
        $this->addresses = collect($this->addresses)->map(fn ($address) =>[
            'from_date' => Carbon::parse($address['from_date'])->format('Y-m-d H:i'),
            'back_date' => Carbon::parse($address['back_date'])->format('Y-m-d H:i')
        ] + $address)
            ->sortBy('from_date')
            ->toArray();

        $this->budgetAddressForm->clear();
        $this->budgetExpenseForm->clear();

        $validated = $this->validate();
        Carbon::setLocale('th');
        $lastEvent        = Carbon::parse(collect($validated['addresses'])->last()['back_date'])->addDay()->startOfDay();
        $lastEventRange   = $lastEvent->clone()->addMonth()->endOfDay();
        $finish_at        = Carbon::parse($validated['finish_at']);
        $hasCustomError   = false;

        // validate finish_at
        if (!$finish_at->between($lastEvent, $lastEventRange)){
            $lastEventFormatted = $lastEvent->translatedFormat('j M y H:i');
            $lastEventRangeFormatted = $lastEventRange->translatedFormat('j M y H:i');

            $this->addError('budgetForm.finish_at', "ลงวันที่จำเป็นต้องอยู่ระหว่างหลังการสิ้นสุดการเดินทาง 30 วัน หรือระหว่าง {$lastEventFormatted} - {$lastEventRangeFormatted}");
            $hasCustomError = true;
        }

        // sum expenses
        $totalAmount = collect($validated['expenses'])->map(function ($expense) {
            return (($expense['days'] !== null && is_numeric($expense['days'])) ? $expense['days'] : 1) * $expense['total'];
        })->sum();

        // validate expenses and value total
        if ($validated['value'] < $totalAmount){
            $formatTotal = number_format($totalAmount);
            $this->addError('budgetForm.value', "จำนวนเงินที่ต้องการเบิกน้อยกว่ารายการค่าใช้จ่ายทั้งหมดซึ่งมีมูลค่า {$formatTotal}บาท");
            $hasCustomError = true;
        }

        if ($hasCustomError) return false;
        return $validated;
    }

    public function save()
    {
        if (!$this->hasPermissionToManage) return false;
        $validated = $this->saveValidate();
        if (!$validated) return false;
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
            'days' => ($expense['days'] !== null && is_numeric($expense['days']) ) ? $expense['days'] : null,
            'total' => $expense['total'],
            'type' => ($expense['type'] !== null) ? $expense['type'] : null,
            'user_id' => $expense['user_id']
        ])->toArray());

        // etc
        $this->dispatch("alert", trans('budgets.alert-budget-saved'));
        $this->dispatch('companionsUpdated');
    }

    public function render()
    {
        return view('livewire.budgets.index');
    }

    /* ADDRESS */
    public function onAddAddress() {
        $raw = collect($this->addresses);
        if ($this->addressEditing !== null) $raw->forget($this->addressEditing); // remove editing index;
        $payload = $this->budgetAddressForm->submit();
        $extract = $this->budgetAddressForm->extract($raw->all());
        $hasEvent = false;

        $from_time = $payload['from_time'];
        $back_time = $payload['back_time'];

        function addEvent($fromDate, $backDate, &$extract, &$hasEvent, $payload) {
            $test = $extract->first(function($item) use ($fromDate, $backDate){
                $iStart = Carbon::parse($item['from_date']);
                $iBack  = Carbon::parse($item['back_date']);

                return  (
                    $iStart->isBetween($fromDate, $backDate) ||
                    $iBack->isBetween($fromDate, $backDate) ||
                    $fromDate->isBetween($iStart, $iBack) ||
                    $backDate->isBetween($iStart, $iBack)
                );
            });

            if ($test != null || $hasEvent) return $hasEvent = true;

            $extract->push([
                'from_date' => $fromDate->format('Y-m-d H:i'),
                'back_date' => $backDate->format('Y-m-d H:i'),
                'multiple'  => $fromDate->isSameDay($backDate) ? true : $payload['multiple'],
            ] + $payload);
        }

        if ($payload['multiple']) {
            // Handle multiple dates
            $this->budgetAddressForm->splitDates($payload['dates'])
                ->each(function ($dates) use ($from_time, $back_time, &$extract, &$hasEvent, $payload) {
                    $dates->each(function ($date) use ($from_time, $back_time, &$extract, &$hasEvent, $payload) {
                        $fromDate = Carbon::parse("{$date} {$from_time}");
                        $backDate = Carbon::parse("{$date} {$back_time}");
                        addEvent($fromDate, $backDate, $extract, $hasEvent, $payload);
                    });
                });
        } else {
            // Handle range of dates
            $dates = collect($payload['dates']);
            $fromDate = Carbon::parse("{$dates->first()} {$from_time}");
            $backDate = Carbon::parse("{$dates->last()} {$back_time}");

            addEvent($fromDate, $backDate, $extract, $hasEvent, $payload);
        }

        if ($hasEvent) return $this->addError('budgetAddressForm.dates', "วันที่ไม่ถูกต้อง มีการเดินทางที่ทับซ้อนกัน!");

        $minimize = $this->budgetAddressForm->minimize($extract);
        $this->addresses = $minimize;
    }

    /* EXPENSE */
    public function onAddExpense() {
        if (!$this->hasPermissionToManage) return false;
        $validated = $this->budgetExpenseForm->submit();
        if($validated['owner'] !== null && (
            $validated['owner'] == $this->budgetForm->budget->user->id ||
            !in_array($validated['owner'], $this->companions->toArray()))
        ) return $this->addError('budgetExpenseForm.owner', "ผู้ใช้ที่เลือกไม่เกี่ยวข้องกับใบเบิกฉบับนี้!");
        if($validated['owner'] === null) $validated['owner'] = $this->budgetForm->budget->user->id;

        $expense   = Expense::where([
            ['id', $validated['expense_id']],
        ])->firstOrFail('label');
        $owner     = $this->budgetForm->budget->user;
        if ($validated['owner'] != null) $owner = User::findOrFail($validated['owner'], 'name');

        $payload = collect($this->expenses);
        $expenseIndex = $payload->search(fn($item) =>
            $item['id'] == $validated['expense_id'] &&
            $item['user_id'] == $validated['owner']
        );

        if ($expenseIndex !== false) {
            $payload = $payload->map(function ($item, $key) use ($validated, $expenseIndex) {
                if ($key === $expenseIndex) $item['total'] = $validated['total'];
                return $item;
            });
        } else {
            $data = [
                'id' => $validated['expense_id'],
                'label' => $expense->label,
                'total' => $validated['total'],
                'days'  => null,
                'type'  => null,
                'user_id'  => $validated['owner'],
                'user_label' => $owner->name
            ];
            $isChildOrETC = $data['user_id'] != $this->budgetForm->budget->user_id || $data['id'] > 3;
            if ($isChildOrETC){
                $data['days'] = null;
                $data['type'] = null;
            }

            $payload->push($data);
        }

        $this->expenses = $payload->sortBy('id')->values();
    }

    public function onRemoveExpense($id, $userId) {
        if (!$this->hasPermissionToManage) return false;

        $this->expenses = collect($this->expenses)
            ->filter(fn($e) => !($e['id'] == $id && $e['user_id'] == $userId));
    }
}
