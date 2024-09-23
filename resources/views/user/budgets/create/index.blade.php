<x-app-layout select2="true">
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight ">
                {{ __('budgets.create-heading') }}
            </h2>
            <p>
                <i>ใบเบิกเงินเลขที่ {{ $serial }}</i>
            </p>
        </div>
    </x-slot>

    @if (session('alert'))
        <x-alert :text="session('alert')['text']" :variant="session('alert')['variant']" />
    @endif

    {{-- BUDGET --}}
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800">
        <div class="max-w-full">
            @include('user.budgets.create.patials.budget-budget')
        </div>
    </div>

    @if ($data)
        {{-- COMPANION --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800 my-2">
            <div class="max-w-full">
                @include('user.budgets.create.patials.budget-companion')
            </div>
        </div>

        {{-- ADDRESS --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800 my-2">
            <div class="max-w-full">
                @include('user.budgets.create.patials.budget-address')
            </div>
        </div>

        {{-- EXPENSE --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800 my-2">
            <div class="max-w-full">
                @include('user.budgets.create.patials.budget-expense')
            </div>
        </div>
    @endif
</x-app-layout>
