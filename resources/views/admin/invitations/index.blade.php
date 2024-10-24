<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-2">
            <h2 class="text-xl font-semibold leading-tight ">
                {{ __('invitations.heading') }}
            </h2>

            <x-button
                variant="primary"
                class="items-center max-w-xs gap-2"
                x-on:click="$dispatch('open-invitation-dialog')"
            >
                <x-heroicon-o-plus class="w-6 h-6" aria-hidden="true" />

                <span>{{__('invitations.add-btn')}}</span>
            </x-button>
        </div>

        <x-alert key="invitations.message" />
    </x-slot>

{{--     <x-invitations.dialog /> --}}
    <livewire:invitations.dialog />
    <livewire:invitations.datatable />
    <x-confirmation variant="danger" />
</x-app-layout>
