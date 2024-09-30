<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight ">
                {{ __('positions.heading') }}
            </h2>

            <x-button
                variant="primary"
                class="items-center max-w-xs gap-2"
                x-on:click.prevent="$dispatch('dialog', {
                    method: 'post',
                    route: '{{route('positions.store')}}',
                    value: ''
                })"
            >
                <x-heroicon-o-plus class="w-6 h-6" aria-hidden="true" />

                <span>{{__('positions.add-btn')}}</span>
            </x-button>
        </div>
    </x-slot>

    @if (session('alert'))
        <x-alert :text="session('alert')['text']" :variant="session('alert')['variant']"/>
    @endif

    <x-positions.dialog />
    <livewire:positions.datatable />
    <x-confirmation variant="danger" />
</x-app-layout>
