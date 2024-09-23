<section class="grid grid-cols-1 gap-2">
    <form wire:submit="save" id="address-add-form">
        <section class="grid grid-cols-9 gap-2">
            <section class="space-y-2 lg:col-span-2 md:col-span-5 col-span-9">
                <x-form.label for="from_location_id" :value="__('budgets.input-address-from')" />
                <div>
                    <select class="w-full outline-none" id="from_location_id">
                        @isset($from_location_id)
                            @isset($from_location_label)
                                <option value="{{ $from_location_id }}" selected>{{ $from_location_label }}</option>
                            @endisset
                        @endisset
                    </select>
                </div>
                <x-form.error :messages="$errors->get('from_location_id')" />
            </section>

            <section class="space-y-2 lg:col-span-2 md:col-span-4 col-span-9">
                <x-form.label for="from_date" :value="__('budgets.input-address-from-datetime')" />
                <x-form.input wire:model="from_date" name="from_date" type="datetime-local" class="block w-full" />
                <x-form.error :messages="$errors->get('from_date')" />
            </section>

            <section class="space-y-2 lg:col-span-2 md:col-span-5 col-span-9">
                <x-form.label for="back_location_id" :value="__('budgets.input-address-back')" />
                <div>
                    <select class="w-full outline-none" id="back_location_id">
                        @isset($back_location_id)
                            @isset($back_location_label)
                                <option value="{{ $back_location_id }}" selected>{{ $back_location_label }}</option>
                            @endisset
                        @endisset
                    </select>
                </div>
                <x-form.error :messages="$errors->get('back_location_id')" />
            </section>

            <section class="space-y-2 lg:col-span-2 md:col-span-4 col-span-9">
                <x-form.label for="back_date" :value="__('budgets.input-address-back-datetime')" />
                <x-form.input wire:model="back_date" name="back_date" type="datetime-local" class="block w-full" />
                <x-form.error :messages="$errors->get('back_date')" />
            </section>

            <section class="space-y-2 lg:col-span-1 md:col-span-9 col-span-9">
                <x-form.label for="submit" :value="__('budgets.table-address-action')" />
                <x-button type="submit" name="submit" form="address-add-form"
                    class="w-full text-end truncate"><i>{{ __('budgets.add-address-btn') }}</i></x-button>
            </section>
        </section>
    </form>
    <hr>
    <section class="relative overflow-x-auto border">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-inherit">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-inherit dark:text-inherit">
                <tr>
                    <th class="px-6 py-3 w-[20%]">{{ __('budgets.table-address-from-label') }}</th>
                    <th class="px-6 py-3 w-[20%]">{{ __('budgets.table-address-from_date') }}</th>
                    <th class="px-6 py-3 w-[20%] text-end">{{ __('budgets.table-address-back-label') }}</th>
                    <th class="px-6 py-3 w-[20%] text-end">{{ __('budgets.table-address-back_date') }}</th>
                    <th class="px-6 py-3 w-[20%] text-end">{{ __('budgets.table-address-action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($addresses as $index => $address)
                    <tr wire:key="address-{{ $address['id'] }}"
                        class="{{ $address['editing'] ?? false ? 'bg-cyan-100' : '' }}">
                        <td class="px-6 py-1">{{ $address['from']['label'] }}</td>
                        <td class="px-6 py-1" data-format="dateandtime"data-value="{{$address['from_date']}}">...</td>
                        <td class="px-6 py-1 text-end">{{ $address['back']['label'] }}</td>
                        <td class="px-6 py-1 text-end" data-format="dateandtime" data-value="{{$address['back_date']}}">...</td>
                        <td class="px-6 py-1 space-x-2 flex justify-end">
                            @if (!($address['editing'] ?? false))
                                <x-button type="button" wire:click.prevent="editAddress({{ $index }})"
                                    icon-only variant="info">
                                    <x-heroicon-o-pencil class="w-6 h-6" />
                                </x-button>
                                <x-button type="button" wire:click.prevent="removeAddress({{ $address['id'] }})"
                                    icon-only variant="danger">
                                    <x-heroicon-o-trash class="w-6 h-6" />
                                </x-button>
                            @else
                                <x-button type="button" class="space-x-2"
                                    wire:click="cancelEditAddress({{ $index }})" icon-only variant="warning">
                                    <x-heroicon-o-x-mark class="w-6 h-6" />
                                </x-button>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-1 text-center">{{ __('budgets.table-addresses-not-found') }}
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
                    const options = {
                        width: '100%',
                        placeholder: @js(__('budgets.input-location-placeholder')),
                        ajax: {
                            url: @js(route('locations.selectize')),
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
                    }

                    $('#from_location_id').select2(options);
                    $('#back_location_id').select2(options);
                }

                initSelectors();
                $('#from_location_id').on('select2:select', (e) => $dispatch('selectedFromLocationId', {
                    item: e.params.data.id,
                    text: e.params.data.text
                }));
                $('#back_location_id').on('select2:select', (e) => $dispatch('selectedBackLocationId', {
                    item: e.params.data.id,
                    text: e.params.data.text
                }));
                Livewire.hook('morph.updated', initSelectors);
                Livewire.hook('morph.updated', __executeAutoFormatter);
            })
        </script>
    @endscript
</section>
