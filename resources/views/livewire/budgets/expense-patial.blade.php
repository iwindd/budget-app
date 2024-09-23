<section class="grid grid-cols-1 gap-2">
    <form wire:submit="save" id="expense-add-form" class="grid grid-cols-9 gap-2">
        <section class="space-y-2 lg:col-span-5 md:col-span-9 col-span-9">
            <x-form.label for="expense_id" :value="__('budgets.input-expense')" />
            <div>
                <select name="expense_id" id="expense-selector" class="w-full">
                    @isset($expense_id)
                        @isset($expense_label)
                            <option value="{{ $expense_id }}" selected>{{ $expense_label }}</option>
                        @endisset
                    @endisset
                </select>
            </div>
            <x-form.error :messages="$errors->get('expense_id')" />
        </section>
        <section class="space-y-2 lg:col-span-1 md:col-span-4 col-span-4">
            <x-form.label for="total" :value="__('budgets.input-total')" />
            <x-form.input wire:model="total" name="total" type="number" class="block w-full" />
            <x-form.error :messages="$errors->get('total')" />
        </section>
        <section class="space-y-2 lg:col-span-2 md:col-span-5 col-span-5">
            <x-form.label for="days" :value="__('budgets.input-days')" />
            <x-form.input wire:model="days" :placeholder="__('budgets.input-days-placeholder')" id="days" name="days" type="number"
                class="block w-full" />
            <x-form.error :messages="$errors->get('days')" />
        </section>
        <section class="space-y-2 lg:col-span-1 md:col-span-9 col-span-9">
            <x-form.label for="submit" :value="__('budgets.table-companion-action')" />
            <x-button type="submit" class="w-full truncate" form="expense-add-form"><i>{{ __('budgets.add-expense-btn') }}</i></x-button>
        </section>
    </form>
    <section class="text-end text-sm text-inherit flex justify-between items-end">
        <header>
            <h3>รายการทั้งหมด</h3>
        </header>
    </section>
    <section class="relative overflow-x-auto border">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-inherit">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-inherit dark:text-inherit">
                <tr>
                    <th class="px-6 py-3 w-[50%]">{{__('budgets.table-expense-name')}}</th>
                    <th class="px-6 py-3 w-[20%]">{{__('budgets.table-expense-days')}}</th>
                    <th class="px-6 py-3 w-[20%] text-end">{{__('budgets.table-expense-total')}}</th>
                    <th class="px-6 py-3 w-[10%] text-end">{{__('budgets.table-expense-action')}}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($expenses as $expense)
                    <tr wire:key="{{ $expense['id'] }}">
                        <td class="px-6 py-1">{{ $expense['expense']['label'] }}</td>
                        <td class="px-6 py-1">{{ $expense['days'] ?? 'ประเภทรวม' }}</td>
                        <td class="px-6 py-1 text-end">{{ $expense['total'] }}</td>
                        <td class="px-6 py-1 text-end">
                            <x-button type="button" wire:click.prevent="removeExpense({{ $expense['id'] }})" icon-only
                                variant="danger">
                                <x-heroicon-o-trash class="w-6 h-6" />
                            </x-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-1 text-center">{{ __('budgets.table-expenses-not-found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    @script
        <script>
            $(document).ready(function(e) {
                window.initSelectors = () => {
                    $('#expense-selector').select2({
                        width: '100%',
                        placeholder: @js(__('budgets.input-expense-placeholder')),
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
                }

                initSelectors();
                $('#expense-selector').on('select2:select', (e) => $dispatch('selectedExpense', {
                    item: e.params.data.id,
                    text: e.params.data.text
                }));
                Livewire.hook('morph.updated', initSelectors);
            })
        </script>
    @endscript
</section>
