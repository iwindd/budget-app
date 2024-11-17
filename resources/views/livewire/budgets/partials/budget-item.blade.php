<section
    class="grid grid-cols-2 gap-1"
    x-data="{
        budget_date: @entangle('budgetForm.date')
    }"
>
    {{-- ORDER --}}
    <section class="md:col-span-1 col-span-2">
        <x-textfield :disabled="!$hasPermissionToManage" lang="budgets.input-order_id" :startIcon="@svg('heroicon-o-paper-clip')" wire:model="budgetForm.order" />
    </section>
    {{-- DATE --}}
    <section class="md:col-span-1 col-span-2">
        <x-datepicker :disabled="!$hasPermissionToManage" lang="budgets.input-order_at" :startIcon="@svg('heroicon-o-calendar')" x-bind:min="budget_date"  wire:model="budgetForm.date" type="date" />
    </section>
    {{-- BUDGET_ITEM_OWNER_NAME --}}
    <section>
        <x-textfield lang="budgets.input-budget-owner-name" wire:model="client_name" disabled />
    </section>
    <section class="grid grid-cols-2 gap-1">
        {{-- BUDGET_ITEM_OWNER_POSITION --}}
        <x-textfield lang="budgets.input-budget-owner-position" wire:model="client_position" disabled />
        {{-- BUDGET_ITEM_OWNER_AFFILIATION --}}
        <x-textfield lang="budgets.input-budget-owner-affiliation" wire:model="client_affiliation" disabled />
    </section>
    <section class="grid grid-cols-2 gap-1 col-span-2 lg:col-span-1">
        {{-- SUBJECT --}}
        <x-textfield :disabled="!$hasPermissionToManage" lang="budgets.input-subject" :startIcon="@svg('heroicon-o-book-open')" wire:model="budgetForm.subject" />
        {{-- HEADER --}}
        <x-textfield :disabled="!$hasPermissionToManage" lang="budgets.input-header" :startIcon="@svg('heroicon-o-map-pin')" wire:model="budgetForm.header" />
    </section>
    <section class="lg:col-span-1 col-span-2">
        <x-selectize
            :disabled="!$hasPermissionToManage"
            :fetch="route('companions.selectize')"
            :options="$budgetForm->companions"
            lang='budgets.input-companion'
            wire:model="companions"
            display="name"
            multiple
            defaultByOptions
        />
    </section>
</section>
