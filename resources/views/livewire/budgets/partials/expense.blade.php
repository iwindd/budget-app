<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800">
    <div class="max-w-full">
        <header>
            <h3 class="font-bold">{{ __('budgets.expense-header') }}</h3>
        </header>
        @if ($budgetItemForm->exists())
            <form wire:submit="onAddExpense" class="flex flex-col lg:flex-row">
                <div class="flex-grow grid grid-cols-8 gap-2">
                    <section class="space-y-2 lg:col-span-5 md:col-span-8 col-span-8">
                        <x-form.label for="budgetItemExpenseForm.expense_id" :value="__('budgets.input-expense')" />
                        <div wire:ignore>
                            <select name="budgetItemExpenseForm.expense_id" id="budgetItemExpenseForm.expense_id"
                                class="w-full expense-selector"></select>
                        </div>
                        <x-form.error :messages="$errors->get('budgetItemExpenseForm.expense_id')" />
                    </section>
                    <section class="space-y-2 lg:col-span-1 md:col-span-5 col-span-4">
                        <x-form.label for="budgetItemExpenseForm.total" :value="__('budgets.input-total')" />
                        <x-form.input wire:model="budgetItemExpenseForm.total" name="budgetItemExpenseForm.total"
                            type="number" class="block w-full" />
                        <x-form.error :messages="$errors->get('budgetItemExpenseForm.total')" />
                    </section>
                    <section class="space-y-2 lg:col-span-2 md:col-span-3 col-span-4">
                        <x-form.label for="budgetItemExpenseForm.days" :value="__('budgets.input-days')" />
                        <x-form.input wire:model="budgetItemExpenseForm.days" :placeholder="__('budgets.input-days-placeholder')"
                            id="budgetItemExpenseForm.days" name="budgetItemExpenseForm.days" type="number"
                            class="block w-full" />
                        <x-form.error :messages="$errors->get('budgetItemExpenseForm.days')" />
                    </section>
                </div>
                <div class="space-y-2 lg:ms-2">
                    <x-form.label class="mt-2 lg:mt-0" for="submit" :value="__('budgets.table-companion-action')" />
                    <x-button type="submit" name="submit"
                        class="w-full justify-center truncate">{{ __('budgets.add-expense-btn') }}</x-button>
                </div>
            </form>

            <section class="relative overflow-x-auto border-none mt-2">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-inherit border-none">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-900/10 dark:text-inherit">
                        <tr>
                            <th class="px-6 py-3 w-[50%]">{{ __('budgets.table-expense-name') }}</th>
                            <th class="px-6 py-3 w-[20%]">{{ __('budgets.table-expense-days') }}</th>
                            <th class="px-6 py-3 w-[20%] text-end">{{ __('budgets.table-expense-total') }}</th>
                            <th class="px-6 py-3 w-[10%] text-end">{{ __('budgets.table-expense-action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($budgetItemForm->budgetItem->budgetItemExpenses as $expense)
                            <tr wire:key="{{ $expense->id }}">
                                <td class="px-6 py-1">{{ $expense->expense->label }}</td>
                                <td class="px-6 py-1">
                                    {{ $expense['days']
                                        ? __('budgets.table-value-expense-days', ['day' => $expense['days']])
                                        : __('budgets.table-value-expense-all') }}
                                </td>
                                <td class="px-6 py-1 text-end">
                                    {{ $format->number($expense->total * ($expense->days ?? 1)) }}
                                </td>
                                <td class="px-6 py-1 flex justify-end">
                                    <x-button type="button" wire:click.prevent="onRemoveExpense({{ $expense['id'] }})"
                                        icon-only variant="danger" size="sm">
                                        <x-heroicon-o-trash class="w-6 h-6" />
                                    </x-button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-1 text-center">
                                    {{ __('budgets.table-expenses-not-found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
            @script
                <script>
                    $(document).ready(function(e) {
                        $('.expense-selector').select2({
                            width: '100%',
                            placeholder: @js(__('budgets.input-expense-placeholder')),
                            tags: true,
                            ajax: {
                                url: @js(route('expenses.selectize')),
                                dataType: 'json',
                                delay: 250,
                                processResults: function(data) {
                                    return {
                                        results: $.map(data, function(item) {
                                            return {
                                                text: item.label,
                                                id: item.id
                                            }
                                        })
                                    };
                                },
                                cache: true
                            }
                        });

                        $('.expense-selector').on('select2:select', (e) => {
                            @this.set(e.target.id, e.params.data.id);
                        });
                    })

                    window.addEventListener('onExpenseSelectorClear', (e) => $(`.expense-selector`).val(null).trigger('change'));
                </script>
            @endscript
        @else
            <x-form.error class="indent-4" :messages="__('budgets.expense-budget-item-not-found')" />
        @endif
    </div>
</div>
