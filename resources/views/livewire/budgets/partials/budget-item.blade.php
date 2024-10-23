<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800">
    <div class="max-w-full">
        <header>
            <h3 class="font-bold">{{ __('budgets.budgetitem-header') }}</h3>
        </header>

        <section class="grid grid-cols-2 gap-2">
            {{-- ORDER --}}
            <section class="space-y-2 md:col-span-1 col-span-2">
                <x-textfield
                    :label="__('budgets.input-order_id')"
                    :error="$errors->get('budgetItemForm.order')"
                    :startIcon="@svg('heroicon-o-paper-clip')"
                    id="budgetItemForm.order"
                    wire:model="budgetItemForm.order"
                />
            </section>
            {{-- DATE --}}
            <section class="space-y-2 md:col-span-1 col-span-2">
                <x-textfield
                    :label="__('budgets.input-order_at')"
                    :error="$errors->get('budgetItemForm.date')"
                    :startIcon="@svg('heroicon-o-calendar')"
                    id="budgetItemForm.date"
                    wire:model="budgetItemForm.date"
                    type="date"
                />
            </section>
            {{-- BUDGET_ITEM_OWNER_NAME --}}
            <section class="space-y-2">
                <x-textfield
                    :label="__('budgets.input-budget-owner-name')"
                    :error="$errors->get('budgetItemForm.name')"
                    id="budgetItemForm.name"
                    wire:model="budgetItemForm.name"
                    disabled
                />
            </section>
            <section class="grid grid-cols-2 gap-2">
                {{-- BUDGET_ITEM_OWNER_POSITION --}}
                <section class="space-y-2">
                    <x-textfield
                        :label="__('budgets.input-budget-owner-position')"
                        wire:model="budgetItemForm.position"
                        disabled
                    />
                </section>
                {{-- BUDGET_ITEM_OWNER_AFFILIATION --}}
                <section class="space-y-2">
                    <x-textfield
                        :label="__('budgets.input-budget-owner-affiliation')"
                        wire:model="budgetItemForm.affiliation"
                        disabled
                    />
                </section>
            </section>
            {{-- HEADER --}}
            <section class="space-y-2 md:col-span-1 col-span-2">
                <x-textfield
                    :label="__('budgets.input-header')"
                    :placeholder="__('budgets.input-header-placeholder')"
                    :error="$errors->get('budgetItemForm.header')"
                    :startIcon="@svg('heroicon-o-map-pin')"
                    id="budgetItemForm.header"
                    wire:model="budgetItemForm.header"
                />
            </section>
            {{-- SUBJECT --}}
            <section class="space-y-2 md:col-span-1 col-span-2">
                <x-textfield
                    :label="__('budgets.input-subject')"
                    :placeholder="__('budgets.input-subject-placeholder')"
                    :error="$errors->get('budgetItemForm.subject')"
                    :startIcon="@svg('heroicon-o-book-open')"
                    id="budgetItemForm.subject"
                    wire:model="budgetItemForm.subject"
                />
            </section>
        </section>
    </div>
</div>
