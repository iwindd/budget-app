@inject('format', 'App\Services\FormatHelperService')

<section class="space-y-2">
    <form wire:submit="save" class="space-y-2" id="budget-form">
        @include('livewire.budgets.partials.budget')
        @include('livewire.budgets.partials.budget-item')
    </form>

    @include('livewire.budgets.partials.companion')

    <div class="p-2 sm:p-2 bg-white shadow sm:rounded-lg dark:bg-gray-800 mt-2">
        <div class="max-w-full">
            <section class="max-w-full col-span-2 flex justify-end">
                <x-button type="submit" form="budget-form" variant="success">บันทึกใบเบิก</x-button>
            </section>
        </div>
    </div>

    @include('livewire.budgets.partials.address')
    @include('livewire.budgets.partials.expense')
    @include('livewire.budgets.extras.travel')
</section>
