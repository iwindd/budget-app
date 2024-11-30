@inject('format', 'App\Services\FormatHelperService')

<section class="space-y-2">
    <div class="bg-white shadow sm:rounded-lg dark:bg-gray-800">
        <div class="max-w-full space-y-4 py-4 sm:py-4">
            <form wire:submit="save" class="space-y-4 px-4 sm:px-8" id="budget-form">
                <h3 class="font-bold">{{ __('budgets.budgets-header') }}</h3>
                @include('livewire.budgets.partials.budget')

                <h3 class="font-bold">{{ __('budgets.budgetitem-header') }}</h3>
                @include('livewire.budgets.partials.budget-item')
            </form>

            <h3 class="font-bold px-4 sm:px-8">{{ __('budgets.expense-header') }}</h3>
            @include('livewire.budgets.partials.expense')

            <h3 class="font-bold px-4 sm:px-8">{{ __('address.header') }}</h3>
            @include('livewire.budgets.partials.address')

            <div class="max-w-full space-y-2 px-4 sm:px-8">
                @if ($hasPermissionToManage)
                    <section class="max-w-full col-span-2 flex justify-end">
                        <x-button type="submit" form="budget-form" variant="success">บันทึกใบเบิก</x-button>
                    </section>
                @endif

                <x-alert key="budget.message"/>
            </div>
        </div>
    </div>
</section>
