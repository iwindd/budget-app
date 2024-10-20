<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800">
    <div class="max-w-full">
        <header>
            <h3 class="font-bold">{{ __('budgets.budgetitem-header') }}</h3>
        </header>

        <section class="grid grid-cols-2 gap-2">
            {{-- ORDER --}}
            <section class="space-y-2 md:col-span-1 col-span-2">
                <x-form.label for="budgetItemForm.order" :value="__('budgets.input-order_id')" />
                <x-form.input id="budgetItemForm.order" wire:model="budgetItemForm.order"
                    name="budgetItemForm.order" type="text" class="block w-full" />
                <x-form.error :messages="$errors->get('budgetItemForm.order')" />
            </section>
            {{-- DATE --}}
            <section class="space-y-2 md:col-span-1 col-span-2">
                <x-form.label for="budgetItemForm.date" :value="__('budgets.input-order_at')" />
                <x-form.input id="budgetItemForm.date" name="budgetItemForm.date" type="date"
                    wire:model="budgetItemForm.date" class="block w-full" />
                <x-form.error :messages="$errors->get('budgetItemForm.date')" />
            </section>
            {{-- BUDGET_ITEM_OWNER_NAME --}}
            <section class="space-y-2">
                <x-form.label for="budgetItemForm.name" :value="__('budgets.input-budget-owner-name')" />
                <x-form.input id="budgetItemForm.name" name="budgetItemForm.name" wire:model="budgetItemForm.name" type="text" disabled
                    class="block w-full" />
                <x-form.error :messages="$errors->get('order_at')" />
            </section>
            <section class="grid grid-cols-2 gap-2">
                {{-- BUDGET_ITEM_OWNER_POSITION --}}
                <section class="space-y-2">
                    <x-form.label for="budgetItemForm.position" :value="__('budgets.input-budget-owner-position')" />
                    <x-form.input id="budgetItemForm.position" name="budgetItemForm.position" wire:model="budgetItemForm.position"  type="text" disabled
                        class="block w-full" />
                    <x-form.error :messages="$errors->get('order_at')" />
                </section>
                {{-- BUDGET_ITEM_OWNER_AFFILIATION --}}
                <section class="space-y-2">
                    <x-form.label for="budgetItemForm.affiliation" :value="__('budgets.input-budget-owner-affiliation')" />
                    <x-form.input id="budgetItemForm.affiliation" name="budgetItemForm.affiliation" wire:model="budgetItemForm.affiliation" type="text"
                        disabled class="block w-full" />
                    <x-form.error :messages="$errors->get('order_at')" />
                </section>
            </section>
            {{-- HEADER --}}
            <section class="space-y-2 md:col-span-1 col-span-2">
                <x-form.label for="budgetItemForm.header" :value="__('budgets.input-header')" />
                <x-form.input id="budgetItemForm.header" wire:model="budgetItemForm.header"
                    name="budgetItemForm.header" :placeholder="__('budgets.input-header-placeholder')" type="text" class="block w-full" />
                <x-form.error :messages="$errors->get('budgetItemForm.header')" />
            </section>
            {{-- SUBJECT --}}
            <section class="space-y-2 md:col-span-1 col-span-2">
                <x-form.label for="budgetItemForm.subject" :value="__('budgets.input-subject')" />
                <x-form.input id="budgetItemForm.subject" wire:model="budgetItemForm.subject"
                    name="budgetItemForm.subject" :placeholder="__('budgets.input-subject-placeholder')" type="text" class="block w-full" />
                <x-form.error :messages="$errors->get('budgetItemForm.subject')" />
            </section>
        </section>
    </div>
</div>
