<x-app-layout
    select2="true"
>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight ">
                {{ __('users.heading') }}
            </h2>

            <x-button
                variant="primary"
                class="items-center max-w-xs gap-2"
                x-on:click="$dispatch('open-users-dialog')"
            >
                <x-heroicon-o-plus class="w-6 h-6" aria-hidden="true" />

                <span>เพิ่มผู้ใช้</span>
            </x-button>
        </div>
    </x-slot>

    <livewire:users.dialog />
    <livewire:users.datatable />
    <x-confirmation />
</x-app-layout>
