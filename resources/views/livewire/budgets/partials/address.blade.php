<div
    class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800"
    x-data="{
        from_date: @entangle('budgetItemAddressForm.from_date')
    }"
>
    <div class="max-w-full">
        <header>
            <h3 class="font-bold">{{ __('budgets.address-header') }}</h3>
        </header>

        @if ($budgetItemForm->exists())
            @include('livewire.budgets.form.address')
        @else
            <x-form.error class="indent-4" :messages="__('budgets.address-budget-item-not-found')" />
        @endif
    </div>
</div>
