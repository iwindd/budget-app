<section class="grid grid-cols-1 gap-2">
    <section id="address-content grid grid-cols-1 gap-2">
        @foreach ($data as $index => $item)
            <section wire:key="address-{{ $index }}" class="grid grid-cols-4 gap-2 mt-2">
                <section class="space-y-2"> {{-- FROM --}}
                    <x-form.label for="data.{{ $index }}.from_location_id" :value="__('budgets.input-address-from')" />
                    <select data-key="from_location_id" class="location-selector w-full outline-none"
                        wire:model.live="data.{{ $index }}.from_location_id"
                        name="address[{{ $index }}][from_location_id]">
                        @isset($old[$index]['from_location_id'])
                            <option value="{{ $old[$index]['from_location_id'] }}" selected>
                                {{ $locations[$old[$index]['from_location_id']] }}</option>
                        @endisset
                    </select>
                    <x-form.error :messages="$errors['address.' . $index . '.from_location_id'][0] ?? ''" />
                </section>
                <section class="space-y-2"> {{-- FROM_DATE --}}
                    <x-form.label for="data.{{ $index }}.from_date" :value="__('budgets.input-address-from-datetime')" />
                    <x-form.input id="data.{{ $index }}.from_date" :value="$old[$index]['from_date'] ?? ''"
                        wire:model.defer="data.{{ $index }}.from_date"
                        name="address[{{ $index }}][from_date]" type="datetime-local" class="block w-full" />
                    <x-form.error :messages="$errors['address.' . $index . '.from_date'][0] ?? ''" />
                </section>
                <section class="space-y-2"> {{-- BACK --}}
                    <x-form.label for="data.{{ $index }}.back_location_id" :value="__('budgets.input-address-back')" />
                    <select data-key="back_location_id" class="location-selector w-full outline-none"
                        wire:model="data.{{ $index }}.back_location_id"
                        name="address[{{ $index }}][back_location_id]">
                        @isset($old[$index]['back_location_id'])
                            <option value="{{ $old[$index]['back_location_id'] }}" selected>
                                {{ $locations[$old[$index]['back_location_id']] }}</option>
                        @endisset
                    </select>
                    <x-form.error :messages="$errors['address.' . $index . '.back_location_id'][0] ?? ''" />
                </section>
                <section class="space-y-2"> {{-- BACK_DATE --}}
                    <x-form.label for="data.{{ $index }}.back_date" :value="__('budgets.input-address-back-datetime')" />
                    <div class="flex space-x-2">
                        <x-form.input id="data.{{ $index }}.back_date" :value="$old[$index]['back_date'] ?? ''"
                            wire:model="data[{{ $index }}][back_date]"
                            name="address[{{ $index }}][back_date]" type="datetime-local"
                            class="block w-full" />
                        @if ($index !== 0)
                            <div>
                                <x-button type="button" wire:click.prevent="removeAddress({{ $index }})"
                                    icon-only variant="danger">
                                    <x-heroicon-o-trash class="w-6 h-6" />
                                </x-button>
                            </div>
                        @endif
                    </div>
                    <x-form.error :messages="$errors['address.' . $index . '.back_date'][0] ?? ''" />
                </section>
            </section>
        @endforeach
    </section>
    <section class="text-end text-sm text-inherit ">
        <x-button type="button" wire:click.prevent="addAddress"><i>{{ __('budgets.add-address-btn') }}</i></x-button>
    </section>
    @script
        <script>
            // load selectize
            Livewire.hook('component.init', createLocationSelector)
            Livewire.hook('morph.added', createLocationSelector)
            Livewire.hook('morph.removed', createLocationSelector)
        </script>
    @endscript
</section>
