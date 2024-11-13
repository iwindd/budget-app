@inject('format', 'App\Services\FormatHelperService')

<section class="space-y-2">
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800">
        <div class="max-w-full space-y-4">
            <form wire:submit="save" class="space-y-4" id="budget-form">
                <h3 class="font-bold">{{ __('budgets.budgets-header') }}</h3>
                @include('livewire.budgets.partials.budget')

                <h3 class="font-bold">{{ __('budgets.budgetitem-header') }}</h3>
                @include('livewire.budgets.partials.budget-item')
            </form>

            <h3 class="font-bold">{{ __('budgets.expense-header') }}</h3>
            @include('livewire.budgets.partials.expense')

            <h3 class="font-bold">{{ __('address.header') }}</h3>
            @include('livewire.budgets.partials.address')

            <div class="max-w-full space-y-2">
                <x-alert key="budget.message"/>

                <section class="max-w-full col-span-2 flex justify-end">
                    <x-button type="submit" form="budget-form" variant="success">บันทึกใบเบิก</x-button>
                </section>
            </div>
        </div>
    </div>
{{--

    @include('livewire.budgets.partials.expense')
    @include('livewire.budgets.extras.travel') --}}
</section>
