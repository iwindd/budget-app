@inject('format', 'App\Services\FormatHelperService')

<section class="space-y-2">
    <div class="bg-white shadow sm:rounded-lg dark:bg-gray-800">
        <div class="max-w-full">
            <form wire:submit="save" class="space-y-4 py-4 sm:py-4" id="budget-form">
                <h3 class="font-bold px-4 sm:px-8">{{ __('budgets.budgets-section-1') }}</h3>
                @include('livewire.budgets.partials.budget')

                <h3 class="font-bold px-4 sm:px-8">{{ __('budgets.budgetitem-header') }}</h3>
                @include('livewire.budgets.partials.budget-item')

                <h3 class="font-bold px-4 sm:px-8">{{ __('budgets.expense-header') }}</h3>
                @include('livewire.budgets.partials.expense')

                <h3 class="font-bold px-4 sm:px-8">{{ __('address.header') }}</h3>
                @include('livewire.budgets.partials.address')

                <h3 class="font-bold px-4 sm:px-8">{{ __('budgets.budgets-header') }}</h3>
                <section class="grid grid-cols-2 gap-1 px-4 sm:px-8">
                    <x-datepicker
                        :disabled="!$hasPermissionToManage"
                        :startIcon="@svg('heroicon-o-calendar')"
                        :root="['class' => 'lg:col-span-1 col-span-2']"
                        lang="budgets.input-date"
                        wire:model="budgetForm.finish_at" type="date"
                    />
                    <x-textfield
                        :disabled="!$hasPermissionToManage"
                        :startIcon="@svg('heroicon-o-banknotes')"
                        :root="['class' => 'lg:col-span-1 col-span-2']"
                        lang="budgets.input-value"
                        wire:model="budgetForm.value" type="number"
                    />
                </section>

                <div class="max-w-full space-y-2 px-4 sm:px-8">
                    @if ($hasPermissionToManage)
                        <section class="max-w-full col-span-2 flex justify-end">
                            <x-button type="submit" form="budget-form" variant="success">บันทึกใบเบิก</x-button>
                        </section>
                    @endif

                    <x-alert key="budget.message"/>
                </div>
            </form>
        </div>
    </div>
</section>
