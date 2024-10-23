<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800">
    <div class="max-w-full">
        <header>
            <h3 class="font-bold">{{ __('budgets.budgets-header') }}</h3>
        </header>

        <section class="grid grid-cols-2 gap-2">
            <x-textfield :label="__('budgets.input-office')" wire:model="budgetForm.office" disabled />
            <x-textfield :label="__('budgets.input-invitation')" wire:model="budgetForm.invitation" disabled />
            <x-textfield :label="__('budgets.input-serial')" wire:model="budgetForm.serial" disabled />
            <x-textfield :label="__('budgets.input-name')" wire:model="budgetForm.name" disabled />
            <x-textfield
                :disabled="!$hasPermissionToManage"
                :startIcon="@svg('heroicon-o-calendar')"
                :root="['class' => 'lg:col-span-1 col-span-2']"
                lang="budgets.input-date"
                wire:model="budgetForm.date"
                type="date"
            />

            <x-textfield
                :disabled="!$hasPermissionToManage"
                :startIcon="@svg('heroicon-o-banknotes')"
                :root="['class' => 'lg:col-span-1 col-span-2']"
                lang="budgets.input-value"
                wire:model="budgetForm.value"
                type="number"
            />
        </section>
    </div>
</div>
