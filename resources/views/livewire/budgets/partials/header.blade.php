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
