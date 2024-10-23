<section class="grid grid-cols-2 gap-2">
    {{-- ORDER --}}
    <section class="space-y-2 md:col-span-1 col-span-2">
        <x-textfield lang="budgets.input-order_id" :startIcon="@svg('heroicon-o-paper-clip')" wire:model="budgetItemForm.order" />
    </section>
    {{-- DATE --}}
    <section class="space-y-2 md:col-span-1 col-span-2">
        <x-textfield lang="budgets.input-order_at" :startIcon="@svg('heroicon-o-calendar')" wire:model="budgetItemForm.date" type="date" />
    </section>
    {{-- BUDGET_ITEM_OWNER_NAME --}}
    <section class="space-y-2">
        <x-textfield lang="budgets.input-budget-owner-name" wire:model="budgetItemForm.name" disabled />
    </section>
    <section class="grid grid-cols-2 gap-2">
        {{-- BUDGET_ITEM_OWNER_POSITION --}}
        <x-textfield lang="budgets.input-budget-owner-position" wire:model="budgetItemForm.position" disabled />
        {{-- BUDGET_ITEM_OWNER_AFFILIATION --}}
        <x-textfield lang="budgets.input-budget-owner-affiliation" wire:model="budgetItemForm.affiliation" disabled />
    </section>
    {{-- HEADER --}}
    <section class="space-y-2 md:col-span-1 col-span-2">
        <x-textfield lang="budgets.input-header" :startIcon="@svg('heroicon-o-map-pin')" wire:model="budgetItemForm.header" />
    </section>
    {{-- SUBJECT --}}
    <section class="space-y-2 md:col-span-1 col-span-2">
        <x-textfield lang="budgets.input-subject" :startIcon="@svg('heroicon-o-book-open')" wire:model="budgetItemForm.subject" />
    </section>
</section>
