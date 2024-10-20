<x-app-layout select2="true">
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight ">
                {{ __('budgets.create-heading', ['serial' => request()->budget]) }}
            </h2>
        </div>
    </x-slot>

    @if (session('alert'))
        <x-alert :text="session('alert')['text']" :variant="session('alert')['variant']" />
    @endif

    {{-- BUDGET --}}
    <livewire:budgets.budget-partial />
</x-app-layout>
