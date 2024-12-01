<div class="max-w-full">
    @if ($hasPermissionToManage)
        <form wire:submit="onAddExpense" class="grid grid-cols-5 gap-1 mb-2 border-b pb-2 px-4 sm:px-8">
            <x-selectize
                lang="expenses.selectize"
                :fetch="route('expenses.selectize')"
                wire:model="budgetExpenseForm.expense"
                :root="['class' => 'space-y-1 col-span-5 lg:col-span-3']"
                create
                :parseInt="false"
                :parseCreate="true"
                :selectOnClose="true"
            />
            <x-textfield
                lang="expenses.input-total"
                wire:model="budgetExpenseForm.total"
                type="number"
                :root="['class' => 'space-y-1 col-span-3 lg:col-span-1']"
            />
            <x-textfield
                lang="expenses.input-days"
                wire:model="budgetExpenseForm.days"
                type="int"
                :root="['class' => 'space-y-1 col-span-3 lg:col-span-1']"
            />
            <x-selectize
                lang="expenses.input-owner"
                :fetch="route('companions.selectize')"
                wire:model="budgetExpenseForm.owner"
                :root="['class' => 'space-y-1 col-span-5 lg:col-span-3']"
                display="name"
            />
            <x-textfield
                lang="expenses.input-type"
                wire:model="budgetExpenseForm.type"
                type="text"
                :root="['class' => 'space-y-1 col-span-3 lg:col-span-1']"
            />
            <div class="col-span-2 lg:col-span-1 pt-6">
                <x-button type="submit" name="submit" class="w-full justify-center truncate">{{ __('budgets.add-expense-btn') }}</x-button>
            </div>
        </form>
    @endif

    @foreach ($expenses as $index => $expense)
        @php
            $childExpense = $hasPermissionToManage && $expense['user_id'] !== $budgetForm->budget->user_id;
            $targetIndex = !$childExpense ? $index : $expenses
                ->search(fn($e) =>
                    $e['id'] == $expense['id'] &&
                    $e['user_id'] == $budgetForm->budget->user_id
                );

            $modelPrefix  = $childExpense ? "expenses.$targetIndex" : "expenses.$targetIndex";
        @endphp
        <div
            class="grid grid-cols-5 gap-1 p-0 odd:bg-secondary-100/75 p-2 px-4 sm:px-8"
            wire:key="{{$expense['id'].'-'.$expense['user_id'].$index}}"
            x-data="{
                days: @entangle("$modelPrefix.days"),
                total: @entangle("expenses.$index.total"),
                get sum(){
                    return new Intl.NumberFormat('th-TH', {
                        style: 'currency',
                        currency: 'THB',
                        minimumFractionDigits: 2,
                    }).format((this.days || 1) * this.total);
                }
            }"
        >
            <x-textfield
                lang="expenses.input-label"
                :helper="$expense['user_id'] !== $budgetForm->budget->user_id ? 'ผู้ใช้: '.$expense['user_label'] : ''"
                :value="$expense['label']"
                :root="['class' => $childExpense ? 'col-span-3' : '']"
                disabled
                class="lg:pl-3 pl-0"
            />

            @if (!$childExpense)
                <x-textfield
                    lang="expenses.input-type"
                    :disabled="$childExpense"
                    :wrapper="['class'=>!$childExpense ? 'bg-white' : '']"
                    :startIcon="@svg('heroicon-o-tag')"
                    wire:model="{{$modelPrefix}}.type"
                    type="text"
                />
                <x-textfield
                    lang="expenses.input-days"
                    :disabled="!$hasPermissionToManage"
                    :wrapper="['class'=>!$childExpense ? 'bg-white' : '']"
                    :startIcon="@svg('heroicon-o-calendar-days')"
                    wire:model="{{$modelPrefix}}.days"
                    type="number"
                />
            @endif
            <x-textfield
                lang="expenses.input-total"
                :disabled="!$hasPermissionToManage"
                :wrapper="['class'=>$hasPermissionToManage ? 'bg-white' : '']"
                :startIcon="@svg('heroicon-o-banknotes')"
                wire:model="expenses.{{$index}}.total"
                type="number"
            />
            <div class="flex gap-1 w-full h-full">
                <x-textfield
                    lang="expenses.input-sum"
                    disabled
                    x-bind:value="sum"
                    :root="['class'=>'flex-grow']"
                    class="text-end"
                />
                @if ($expense['id'] > 3 || $expense['user_id'] != $budgetForm->budget->user_id)
                    <div class="pt-5">
                        <x-button wire:click="onRemoveExpense({{$expense['id']}}, {{$expense['user_id']}})" type="button" icon-only variant="danger" size="sm">
                            <x-heroicon-o-trash class="w-7 h-full" />
                        </x-button>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
