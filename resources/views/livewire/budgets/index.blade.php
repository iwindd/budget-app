@inject('format', 'App\Services\FormatHelperService')

<section class="space-y-2">
    <form wire:submit="save" class="space-y-2">
        @include('livewire.budgets.partials.budget')
        @include('livewire.budgets.partials.budget-item')

        <div class="p-2 sm:p-2 bg-white shadow sm:rounded-lg dark:bg-gray-800">
            <div class="max-w-full">
                <section class="max-w-full col-span-2 flex justify-end">
                    <x-button type="submit" variant="success">บันทึกใบเบิก</x-button>
                </section>
            </div>
        </div>
    </form>

    @include('livewire.budgets.partials.companion')
    @include('livewire.budgets.partials.address')
</section>
