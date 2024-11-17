<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight ">
                {{ __('budgets.heading') }}
            </h2>

            <x-button
                variant="primary"
                class="items-center max-w-xs gap-2"
                x-on:click.prevent="$dispatch('open-modal', 'find-budget-form')"
            >
                <x-heroicon-o-magnifying-glass class="w-6 h-6" aria-hidden="true" />

                <span>{{__('budgets.dialog-confirm-btn')}}</span>
            </x-button>
        </div>
    </x-slot>

    @if (session('alert'))
        <x-alert :text="session('alert')['text']" :variant="session('alert')['variant']"/>
    @endif

    <x-budgets.dialog />
    <livewire:budgetitem.datatable />
</x-app-layout>
