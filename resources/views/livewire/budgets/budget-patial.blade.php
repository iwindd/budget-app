<form wire:submit="save" class="space-y-2">
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800">
        <div class="max-w-full">
            <header>
                <h3 class="font-bold">{{ __('budgets.budgets-header') }}</h3>
            </header>

            <section class="grid grid-cols-2 gap-2">
                <section class="space-y-2"> {{-- OFFICE --}}
                    <x-form.label for="budgetForm.office" :value="__('budgets.input-office')" />
                    <x-form.input id="budgetForm.office" name="budgetForm.office" wire:model="budgetForm.office" disabled
                        type="text" class="block w-full" />
                </section>
                <section class="space-y-2"> {{-- INVITATION --}}
                    <x-form.label for="budgetForm.invitation" :value="__('budgets.input-invitation')" />
                    <x-form.input id="budgetForm.invitation" name="budgetForm.invitation"
                        wire:model="budgetForm.invitation" disabled type="text" class="block w-full" />
                </section>
                <section class="space-y-2"> {{-- SERIAL --}}
                    <x-form.label for="budgetForm.serial" :value="__('budgets.input-serial')" />
                    <x-form.input id="budgetForm.serial" wire:model="budgetForm.serial" disabled name="serial"
                        type="text" class="block w-full" />
                    <x-form.error :messages="$errors->get('budgetForm.serial')" />
                </section>
                <section class="space-y-2"> {{-- DATE --}}
                    <x-form.label for="budgetForm.date" :value="__('budgets.input-date')" />
                    <x-form.input id="budgetForm.date" name="budgetForm.date" type="date"
                        wire:model="budgetForm.date" class="block w-full" />
                    <x-form.error :messages="$errors->get('budgetForm.date')" />
                </section>
                <section class="space-y-2"> {{-- NAME --}}
                    <x-form.label for="budgetForm.name" :value="__('budgets.input-name')" />
                    <x-form.input id="budgetForm.name" name="budgetForm.name" disabled type="text"
                        wire:model="budgetForm.name" class="block w-full" />
                </section>
                <section class="space-y-2"> {{-- VALUE --}}
                    <x-form.label for="budgetForm.value" :value="__('budgets.input-value')" />
                    <x-form.input id="budgetForm.value" name="value" type="number" wire:model="budgetForm.value"
                        class="block w-full" :placeholder="__('budgets.input-value-placeholder')" />
                    <x-form.error :messages="$errors->get('budgetForm.value')" />
                </section>
            </section>
        </div>
    </div>

    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800">
        <div class="max-w-full">
            <header>
                <h3 class="font-bold">{{ __('budgets.budgetitem-header') }}</h3>
            </header>

            <section class="grid grid-cols-2 gap-2">
                {{-- ORDER --}}
                <section class="space-y-2">
                    <x-form.label for="budgetItemForm.order" :value="__('budgets.input-order_id')" />
                    <x-form.input id="budgetItemForm.order" wire:model="budgetItemForm.order"
                        name="budgetItemForm.order" type="text" class="block w-full" />
                    <x-form.error :messages="$errors->get('budgetItemForm.order')" />
                </section>
                {{-- DATE --}}
                <section class="space-y-2">
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
                <section class="space-y-2">
                    <x-form.label for="budgetItemForm.header" :value="__('budgets.input-header')" />
                    <x-form.input id="budgetItemForm.header" wire:model="budgetItemForm.header"
                        name="budgetItemForm.header" :placeholder="__('budgets.input-header-placeholder')" type="text" class="block w-full" />
                    <x-form.error :messages="$errors->get('budgetItemForm.header')" />
                </section>
                {{-- SUBJECT --}}
                <section class="space-y-2">
                    <x-form.label for="budgetItemForm.subject" :value="__('budgets.input-subject')" />
                    <x-form.input id="budgetItemForm.subject" wire:model="budgetItemForm.subject"
                        name="budgetItemForm.subject" :placeholder="__('budgets.input-subject-placeholder')" type="text" class="block w-full" />
                    <x-form.error :messages="$errors->get('budgetItemForm.subject')" />
                </section>
            </section>
        </div>
    </div>

    <div class="p-2 sm:p-2 bg-white shadow sm:rounded-lg dark:bg-gray-800">
        <div class="max-w-full">
            <section class="max-w-full col-span-2 flex justify-end">
                <x-button type="submit" variant="success">บันทึกใบเบิก</x-button>
            </section>
        </div>
    </div>
</form>
