<div class="max-w-full"
    x-data="{
        expenses: @entangle('expenses')
    }"
>
    @if ($hasPermissionToManage)
        <form wire:submit="onAddExpense" class="grid grid-cols-5 gap-1 mb-2 border-b pb-2 px-4 sm:px-8">
            <x-selectize
                lang="expenses.selectize"
                :fetch="route('expenses.selectize')"
                wire:model="budgetExpenseForm.expense"
                :root="['class' => 'space-y-1 col-span-5 md:col-span-3 lg:col-span-2']"
                create
                :parseInt="false"
                :parseCreate="true"
                :selectOnClose="true"
            />
            <x-textfield
                lang="expenses.input-total"
                wire:model="budgetExpenseForm.total"
                type="number"
                :root="['class' => 'space-y-1 col-span-2 md:col-span-2 lg:col-span-1']"
            />
            <x-selectize
                lang="expenses.input-owner"
                :fetch="route('companions.selectize')"
                wire:model="budgetExpenseForm.owner"
                :root="['class' => 'space-y-1 col-span-3 md:col-span-3 lg:col-span-1']"
                display="name"
                trackOnly="companions"
                data-allow-clear="true"
            />
            <div class="col-span-5 md:col-span-2 lg:col-span-1 md:pt-6 lg:pt-6">
                <x-button type="submit" name="submit" class="w-full justify-center truncate">{{ __('budgets.add-expense-btn') }}</x-button>
            </div>
        </form>
    @endif

    @foreach ($expenses as $index => $expense)
        @php
            $childExpense = $expense['user_id'] !== $budgetForm->budget->user_id || $expense['id'] > 3;
        @endphp
        <div
            class="grid grid-cols-5 gap-1 p-0 odd:bg-secondary-100/75 p-2 px-4 sm:px-8"
            wire:key="{{$expense['id'].'-'.$expense['user_id'].$index}}"
            x-data="{
                _days: @entangle("expenses.$index.days"),
                total: @entangle("expenses.$index.total"),
                get days(){
                    try{
                        return this.expenses.find(e => e.id == @js($expense['id']) && e.user_id == @js($budgetForm->budget->user_id)).days
                    }catch{
                        return this._days;
                    }
                },
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
                :root="['class' => ($childExpense ? ' col-span-2 md:col-span-2 lg:col-span-3' : 'col-span-3 md:col-span-2 lg:col-span-1')]"
                :error="$errors->get('expenses.' . $index . '.user_id')"
                disabled
                class="lg:pl-3 pl-0"
            />

            @if (!$childExpense)
                <x-textfield
                    lang="expenses.input-type"
                    :disabled="$childExpense"
                    :wrapper="['class'=>!$childExpense ? 'bg-white' : '']"
                    :root="['class'=>'col-span-2 md:col-span-1 lg:col-span-1']"
                    :startIcon="@svg('heroicon-o-tag')"
                    wire:model="expenses.{{$index}}.type"
                    type="text"
                />
                <x-textfield
                    lang="expenses.input-days"
                    :disabled="!$hasPermissionToManage"
                    :wrapper="['class'=>!$childExpense ? 'bg-white' : '']"
                    :startIcon="@svg('heroicon-o-calendar-days')"
                    :root="['class'=>'col-span-2 md:col-span-1 lg:col-span-1']"
                    wire:model="expenses.{{$index}}.days"
                    type="number"
                />
            @endif
            <x-textfield
                lang="expenses.input-total"
                :disabled="!$hasPermissionToManage"
                :wrapper="['class'=>$hasPermissionToManage ? 'bg-white' : '']"
                :startIcon="@svg('heroicon-o-banknotes')"
                :root="['class'=>'col-span-3 md:col-span-1 lg:col-span-1']"
                wire:model="expenses.{{$index}}.total"
                type="number"
            />
            <div class="{{$childExpense ? 'col-span-5 md:col-span-2 lg:col-span-1' : 'col-span-5 lg:col-span-1'}} flex gap-1 w-full h-full">
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
