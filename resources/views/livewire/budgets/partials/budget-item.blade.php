<section
    class="grid grid-cols-2 gap-1"
    x-data="{
        budget_date: @entangle('budgetForm.date')
    }"
>
    {{-- ORDER --}}
    <section class="md:col-span-1 col-span-2">
        <x-textfield lang="budgets.input-order_id" :startIcon="@svg('heroicon-o-paper-clip')" wire:model="budgetForm.order" />
    </section>
    {{-- DATE --}}
    <section class="md:col-span-1 col-span-2">
        <x-datepicker lang="budgets.input-order_at" :startIcon="@svg('heroicon-o-calendar')" x-bind:min="budget_date"  wire:model="budgetForm.date" type="date" />
    </section>
    {{-- BUDGET_ITEM_OWNER_NAME --}}
    <section>
        <x-textfield lang="budgets.input-budget-owner-name" wire:model="budgetForm.name" disabled />
    </section>
    <section class="grid grid-cols-2 gap-1">
        {{-- BUDGET_ITEM_OWNER_POSITION --}}
        <x-textfield lang="budgets.input-budget-owner-position" wire:model="budgetForm.position" disabled />
        {{-- BUDGET_ITEM_OWNER_AFFILIATION --}}
        <x-textfield lang="budgets.input-budget-owner-affiliation" wire:model="budgetForm.affiliation" disabled />
    </section>
    <section class="grid grid-cols-2 gap-1 col-span-2 lg:col-span-1">
        {{-- SUBJECT --}}
        <x-textfield lang="budgets.input-subject" :startIcon="@svg('heroicon-o-book-open')" wire:model="budgetForm.subject" />
        {{-- HEADER --}}
        <x-textfield lang="budgets.input-header" :startIcon="@svg('heroicon-o-map-pin')" wire:model="budgetForm.header" />
    </section>
    <section class="lg:col-span-1 col-span-2">
        <x-selectize
            :fetch="route('companions.selectize')"
            lang='budgets.input-companion'
            wire:model="companions"
            display="name"
            multiple
        />
    </section>
</section>
