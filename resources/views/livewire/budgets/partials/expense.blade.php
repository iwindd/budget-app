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
            <div class="col-span-2 lg:col-span-1 pt-6">
                <x-button type="submit" name="submit" class="w-full justify-center truncate">{{ __('budgets.add-expense-btn') }}</x-button>
            </div>
        </form>
    @endif

    @foreach ($expenses as $index => $expense)
        <div
            class="grid grid-cols-4 gap-1 p-0 odd:bg-secondary-100/75 p-2 px-4 sm:px-8"
            wire:key="{{$expense['id']}}"
            x-data="{
                days: @entangle("expenses.$index.days"),
                total: @entangle("expenses.$index.total"),
                split: @js($expense['split']),
                get sum(){
                    return new Intl.NumberFormat('th-TH', {
                        style: 'currency',
                        currency: 'THB',
                        minimumFractionDigits: 2,
                    }).format((this.split ? this.days : 1) * this.total);
                }
            }"
        >
            <div class="{{!$expense['split'] ? "col-span-2" : ""}}">
                <x-textfield lang="expenses.input-label" :value="$expense['label']" disabled class="lg:pl-3 pl-0" />
            </div>
            @if ($expense['split'])
                <x-textfield
                    lang="expenses.input-days"
                    :disabled="!$hasPermissionToManage"
                    :wrapper="['class'=>$hasPermissionToManage ? 'bg-white' : '']"
                    :startIcon="@svg('heroicon-o-calendar-days')"
                    wire:model="expenses.{{$index}}.days"
                    type="number"
                />
            @endif
            @if (!$expense['default'])
                <div class="col-span-2 gap-1 grid grid-cols-2">
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
                        @if ($expense['merge'] && $hasPermissionToManage)
                            <div class="pt-5">
                                <x-button wire:click="onRemoveExpense({{$expense['id']}})" type="button" icon-only variant="danger" size="sm">
                                    <x-heroicon-o-trash class="w-7 h-full" />
                                </x-button>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    @endforeach
</div>
