<section class="grid grid-cols-1 gap-2">
    <section id="address-content grid grid-cols-1 gap-2">
        @foreach ($data as $index => $item)
            <section wire:key="address-{{$index}}" class="grid grid-cols-4 gap-2 mt-2">
                <section class="space-y-2">
                    <x-form.label for="data.{{ $index }}.from" :value="__('budgets.input-address-from')" />

                    <select class="location-selector w-full outline-none" wire.model="data.{{ $index }}.from" name="address[{{ $index }}][from]"></select>
                </section>
                <section class="space-y-2">
                    <x-form.label for="data.{{ $index }}.from_date" :value="__('budgets.input-address-from-datetime')" />

                    <x-form.input id="data.{{ $index }}.from_date" name="address[{{ $index }}][from_date]" type="datetime-local" class="block w-full" />
                </section>
                <section class="space-y-2">
                    <x-form.label for="data.{{ $index }}.back" :value="__('budgets.input-address-back')" />
                    <select class="location-selector w-full outline-none" wire.model="data.{{ $index }}.back" name="address[{{ $index }}][back]"></select>
                </section>
                <section class="space-y-2">
                    <x-form.label for="data.{{ $index }}.back_date" :value="__('budgets.input-address-back-datetime') " />
                    <div class="flex space-x-2">
                        <x-form.input id="data.{{ $index }}.back_date" name="address[{{ $index }}][back_date]" type="datetime-local" class="block w-full" />
                        @if ($index !== 0)
                            <div>
                                <x-button type="button" wire:click.prevent="removeAddress({{ $index }})" icon-only variant="danger">
                                    <x-heroicon-o-trash class="w-6 h-6" />
                                </x-button>
                            </div>
                        @endif
                    </div>
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
