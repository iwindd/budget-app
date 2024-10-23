<div
    class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800"
    x-data="{
        from_date: @entangle('budgetItemAddressForm.from_date')
    }"
>
    <div class="max-w-full">
        <header>
            <h3 class="font-bold">{{ __('budgets.address-header') }}</h3>
        </header>
        @if ($budgetItemForm->exists())
            <form wire:submit="onAddAddress" class="mb-2 flex lg:flex-row flex-col">
                <section class="grid grid-cols-4 gap-2 grow flex-grow">
                    @php
                        $root = ['class' => 'space-y-2 lg:col-span-1 md:col-span-2 col-span-4'];
                    @endphp
                    <x-selectize :fetch="route('locations.selectize')" :root="$root" lang='budgets.input-address-from'
                        wire:model="budgetItemAddressForm.from_location_id" />
                    <x-textfield :root="$root" lang="budgets.input-address-from-datetime"
                        wire:model="budgetItemAddressForm.from_date" type="datetime-local" />
                    <x-selectize :fetch="route('locations.selectize')" :root="$root" lang='budgets.input-address-back'
                        wire:model="budgetItemAddressForm.back_location_id" />
                    <x-textfield :root="$root" lang="budgets.input-address-back-datetime"
                        wire:model="budgetItemAddressForm.back_date" x-bind:min="from_date" type="datetime-local" />
                </section>
                <div class="space-y-2 lg:pl-2 lg:mt-0 mt-2">
                    <x-form.label for="submit" :value="__('budgets.table-address-action')" />
                    <x-button type="submit" name="submit"
                        class="w-full justify-center truncate">{{ __('budgets.add-address-btn') }}</x-button>
                </div>
            </form>
            <section class="relative overflow-x-auto border-none">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-inherit border-none">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-900/10 dark:text-inherit ">
                        <tr>
                            <th class="px-6 py-3 w-[20%]">{{ __('budgets.table-address-from-label') }}</th>
                            <th class="px-6 py-3 w-[20%]">{{ __('budgets.table-address-from_date') }}</th>
                            <th class="px-6 py-3 w-[20%] text-end">{{ __('budgets.table-address-back-label') }}</th>
                            <th class="px-6 py-3 w-[20%] text-end">{{ __('budgets.table-address-back_date') }}</th>
                            <th class="px-6 py-3 w-[20%] text-end">{{ __('budgets.table-address-action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($budgetItemForm->budgetItem->budgetItemAddresses as $index => $address)
                            @php
                                $isEditing = $address->is($budgetItemAddressForm->budgetItemAddress);
                            @endphp
                            <tr wire:key="address-{{ $address['id'] }}"
                                class="{{ $isEditing ? 'bg-gray-200 dark:bg-gray-900' : '' }}">
                                <td class="px-6 py-1">{{ $address['from']['label'] }}</td>
                                <td class="px-6 py-1">{{ $format->date($address['from_date']) }}</td>
                                <td class="px-6 py-1 text-end">{{ $address['back']['label'] }}</td>
                                <td class="px-6 py-1 text-end">{{ $format->date($address['back_date']) }}</td>
                                <td class="px-6 py-1 space-x-2 flex justify-end">
                                    @if (!$isEditing)
                                        <x-button type="button"
                                            wire:click.prevent="onEditAddress({{ $address['id'] }})" icon-only
                                            variant="info" size="sm">
                                            <x-heroicon-o-pencil class="w-6 h-6" />
                                        </x-button>
                                        <x-button type="button"
                                            wire:click.prevent="onRemoveAddress({{ $address['id'] }})" icon-only
                                            variant="danger" size="sm">
                                            <x-heroicon-o-trash class="w-6 h-6" />
                                        </x-button>
                                    @else
                                        <x-button type="button" class="space-x-2" wire:click="onCancelEditAddress()"
                                            icon-only variant="warning" size="sm">
                                            <x-heroicon-o-x-mark class="w-6 h-6" />
                                        </x-button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-1 text-center">
                                    {{ __('budgets.table-addresses-not-found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
        @else
            <x-form.error class="indent-4" :messages="__('budgets.address-budget-item-not-found')" />
        @endif
    </div>
</div>
