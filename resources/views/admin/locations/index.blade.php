<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-2">
            <h2 class="text-xl font-semibold leading-tight ">
                {{ __('locations.heading') }}
            </h2>

            <x-button
                variant="primary"
                class="items-center max-w-xs gap-2"
                x-on:click="$dispatch('open-location-dialog')"
            >
                <x-heroicon-o-plus class="w-6 h-6" aria-hidden="true" />

                <span>{{__('locations.add-btn')}}</span>
            </x-button>
        </div>

        <x-alert key="locations.message" />
    </x-slot>

    <livewire:locations.dialog />
    <livewire:locations.datatable />
    <x-confirmation />
</x-app-layout>
