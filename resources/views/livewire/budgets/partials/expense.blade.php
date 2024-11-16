<div
    class="max-w-full"
    x-data="{
        expenses: @entangle('expenses'),
        removeExpense(id){
            $wire.onRemoveExpense(id);
        }
    }"
>
    @php
    $expenseError = array_merge(
        $errors->get('expenses', []),
        $errors->get('expenses.*', []),
    );
    @endphp
    <form wire:submit="onAddExpense" class="grid grid-cols-5 gap-1 mb-2 border-b pb-2">
        <x-textfield value="เพิ่มค่าใช้จ่ายอื่นๆ" disabled class="lg:pl-3 pl-0" :root="['class'=>'col-span-2 lg:col-span-1']" />
        <x-selectize
            lang="expenses.selectize"
            :fetch="route('expenses.selectize')"
            wire:model="budgetExpenseForm.expense"
            :root="['class' => 'space-y-1 col-span-3 lg:col-span-2']"
            create
            :parseInt="false"
            :parseCreate="true"
        />
        <x-textfield
            lang="expenses.input-total"
            wire:model="budgetExpenseForm.total"
            type="number"
            :root="['class' => 'space-y-1 col-span-3 lg:col-span-1']"
        />
        <div class="col-span-2 lg:col-span-1">
            <x-button type="submit" name="submit" class="w-full justify-center truncate">{{ __('budgets.add-expense-btn') }}</x-button>
        </div>
    </form>

    <template x-for="(expense, index) in expenses">
        <div class="grid grid-cols-4 gap-1">
            <div :class="{
                'col-span-2': !expense.split,
            }">
                <x-textfield x-bind:value="expense.label" disabled class="lg:pl-3 pl-0" />
            </div>
            <template x-if="expense.split">
                <x-textfield lang="expenses.input-days" x-model="expenses[index].days" type="number" />
            </template>
            <template x-if="!expense.default">
                <div class="col-span-2 gap-1 grid grid-cols-2">
                    <x-textfield lang="expenses.input-total" x-model="expenses[index].total" type="number" />

                    <div class="flex gap-1 w-full h-full">
                        <x-textfield x-bind:value="new Intl.NumberFormat('th-TH', {
                            style: 'currency',
                            currency: 'THB',
                            minimumFractionDigits: 2,
                        }).format(expenses[index].days * expenses[index].total)" disabled :root="['class'=>'flex-grow']" class="text-end" />
                        <template x-if="expense.merge">
                            <div>
                                <x-button x-on:click="removeExpense(expense.id)" type="button" icon-only variant="danger" size="sm">
                                    <x-heroicon-o-trash class="w-7 h-full" />
                                </x-button>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </template>

    <section>
        @foreach ($expenseError as $error)
            <x-form.error :messages="$error" />
        @endforeach
    </section>
</div>
