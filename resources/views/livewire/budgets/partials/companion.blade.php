<div>
    <x-selectize
        :fetch="route('companions.selectize')"
        lang='budgets.input-companion'
        wire:model="companions"
        display="name"
        multiple
    />
{{--
    <x-selectize
        :fetch="route('companions.selectize')"
        lang='budgets.input-companion'
        wire:model="companions2"
        display="name"
    /> --}}
</div>

{{-- <div class="max-w-full">
    @if ($budgetItemForm->exists())
        @if ($hasPermissionToManage)
            <form wire:submit="onAddCompanion" class="flex lg:flex-row md:flex-row flex-col">
                <div class="flex-grow space-y-2">
                    <x-selectize
                        :fetch="route('companions.selectize')"
                        lang='budgets.input-companion'
                        wire:model="budgetItemCompanionFrom.user_id"
                        display="name"
                    />
                </div>
                <div class="space-y-2 lg:ms-2 lg:mt-0 md:ms-2 md:mt-0 mt-2">
                    <x-form.label class="mt-2 lg:mt-0" for="submit" :value="__('budgets.table-companion-action')" />
                    <x-button type="submit" name="submit"
                        class="w-full justify-center truncate ">{{ __('budgets.add-companion-btn') }}</x-button>
                </div>
            </form>
        @endif

        <section class="relative overflow-x-auto border-none mt-2">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-inherit border-none">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-900/10 dark:text-inherit">
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
                                <td class="px-6 py-1 flex justify-end">
                                    <x-button type="button" wire:click.prevent="onRemoveCompanion({{ $companion['id'] }})"
                                        icon-only variant="danger" size="sm">
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
        </section>
    @else
        <x-form.error class="indent-4" :messages="__('budgets.companion-budget-item-not-found')" />
    @endif
</div> --}}
