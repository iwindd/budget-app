<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800">
    <div class="max-w-full">
        <header>
            <h3 class="font-bold">{{ __('budgets.companion-header') }}</h3>
        </header>
        @if ($budgetItemForm->exists())
            <form wire:submit="onAddCompanion" class="flex lg:flex-row md:flex-row flex-col">
                <div class="flex-grow">
                    <div wire:ignore>
                        <select class="w-full companions-selector" id="budgetItemCompanionFrom.user_id"></select>
                    </div>
                    <x-form.error :messages="$errors->get('budgetItemCompanionFrom.user_id')" />
                </div>
                <div>
                    <x-button type="submit" name="submit"
                        class="w-full text-center truncate lg:ms-2 lg:mt-0 md:ms-2 md:mt-0 mt-2"><i>{{ __('budgets.add-companion-btn') }}</i></x-button>
                </div>
            </form>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-inherit">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-inherit dark:text-inherit">
                    <tr>
                        <th class="px-6 py-3 w-[25%]">{{ __('budgets.table-companion-name') }}</th>
                        <th class="px-6 py-3 ">{{ __('budgets.table-companion-type') }}</th>
                        <th class="px-6 py-3 w-[20%]">{{ __('budgets.table-companion-expense') }}</th>
                        <th class="px-6 py-3 w-[20%] ">{{ __('budgets.table-companion-address') }}</th>
                        <th class="px-6 py-3 text-end">{{ __('budgetitems.table-hasData') }}</th>
                        @if ($hasPermissionToManage)
                            <th class="px-6 py-3 text-end">{{ __('budgets.table-companion-action') }}</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($budgetForm->budget->budgetItems->where('user_id', '!=', Auth::user()->id) as $companion)
                        <tr wire:key="{{ $companion['id'] }}">
                            <td class="px-6 py-1">{{ $companion->user->name }}</td>
                            <td class="px-6 py-1">
                                {!! __('budgets.table-value-companion-type-'.($format->isBudgetOwner($budgetForm->budget, $companion) ? 'owner' : 'companion')) !!}
                            </td>
                            <td class="px-6 py-1">
                                {{ __('budgets.table-value-companion-expense', [
                                    'count' => $format->number($companion->budgetItemExpenses->count()),
                                    'sum' => $format->getBudgetItemExpenseSum($companion),
                                ]) }}
                            </td>
                            <td class="px-6 py-1">
                                {{ __('budgets.table-value-companion-address', [
                                        'count' => $format->number($companion->budgetItemAddresses->count()),
                                    ]+ $format->getBudgetItemAddressSum($companion)) }}
                            </td>
                            <td class="px-6 py-1 text-end">
                                {!! __('budgetitems.table-hasData-'.($format->isBudgetItemFinished($companion) ? 'true' : 'false')) !!}
                            </td>
                            @if ($hasPermissionToManage)
                                <td class="px-6 py-1 text-end">
                                    <x-button type="button" wire:click.prevent="onRemoveCompanion({{ $companion['id'] }})"
                                        icon-only variant="danger">
                                        <x-heroicon-o-trash class="w-6 h-6" />
                                    </x-button>
                                </td>
                            @endif
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
            @script
                <script>
                    $(document).ready(function(e) {
                        $('.companions-selector').select2({
                            width: '100%',
                            placeholder: @js(__('budgets.input-companion-placeholder')),
                            ajax: {
                                url: @js(route('users.companions')),
                                dataType: 'json',
                                delay: 250,
                                processResults: function(data) {
                                    return {
                                        results: $.map(data, function(item) {
                                            return {
                                                text: item.name,
                                                id: item.id
                                            }
                                        })
                                    };
                                },
                                cache: true
                            }
                        });

                        $('.companions-selector').on('select2:select', (e) => {
                            @this.set(e.target.id, e.params.data.id);
                        });
                    })

                    window.addEventListener('onCompanionSelectorClear', (e) => $(`.companions-selector`).val(null).trigger('change'));
                </script>
            @endscript
        @else
            <x-form.error class="indent-4" :messages="__('budgets.companion-budget-item-not-found')" />
        @endif
    </div>
</div>
