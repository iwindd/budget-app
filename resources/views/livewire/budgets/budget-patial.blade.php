<section>
    <form wire:submit="save" class="space-y-2">
        <section class="grid grid-cols-2 gap-2">
            <section class="space-y-2"> {{-- SERIAL --}}
                <x-form.label for="serial" :value="__('budgets.input-serial')" />
                <x-form.input id="serial" value="{{ $serial }}" disabled name="serial" type="text"
                    class="block w-full" />
                <x-form.error :messages="$errors->get('serial')" />
                <x-form.error :messages="$errors->get('isOwner')" />
            </section>
            <section class="space-y-2"> {{-- DATE --}}
                <x-form.label for="date" :value="__('budgets.input-date')" />
                <x-form.input id="date" name="date" type="date" :disabled="!$isOwner" wire:model="date"
                    class="block w-full" />
                <x-form.error :messages="$errors->get('date')" />
            </section>
            <section class="space-y-2"> {{-- NAME --}}
                <x-form.label :value="__('budgets.input-name')" />
                <x-form.input id="name" :value="$name" disabled type="text" class="block w-full" />
            </section>
            <section class="space-y-2"> {{-- VALUE --}}
                <x-form.label for="value" :value="__('budgets.input-value')" />
                <x-form.input id="value" name="value" type="number" wire:model="value" class="block w-full"
                    :disabled="!$isOwner" :placeholder="__('budgets.input-value-placeholder')" />
                <x-form.error :messages="$errors->get('value')" />
            </section>
        </section>
        <hr class="col-span-2 my-3">
        <section class="grid grid-cols-2 gap-2">
            <section class="space-y-2"> {{-- OFFICE --}}
                <x-form.label for="office" :value="__('budgets.input-office')" />
                <x-form.input id="office" :value="$office" disabled name="office" type="text"
                    class="block w-full" />
            </section>
            <section class="space-y-2"> {{-- INVITATION --}}
                <x-form.label for="invitation" :value="__('budgets.input-invitation')" />
                <x-form.input id="invitation" :value="$invitation" disabled name="invitation" type="text"
                    class="block w-full" />
            </section>
        </section>
        <section class="grid grid-cols-2 gap-2">
            <section class="space-y-2"> {{-- ORDER_ID --}}
                <x-form.label for="order_id" :value="__('budgets.input-order_id')" />
                <x-form.input id="order_id" wire:model="order_id" name="order_id" type="text"
                    class="block w-full" />
                <x-form.error :messages="$errors->get('order_id')" />
            </section>
            <section class="space-y-2"> {{-- ORDER_AT --}}
                <x-form.label for="order_at" :value="__('budgets.input-order_at')" />
                <x-form.input id="order_at" name="order_at" type="date" wire:model="order_at"
                    class="block w-full" />
                <x-form.error :messages="$errors->get('order_at')" />
            </section>
            <section class="space-y-2"> {{-- BUDGET_ITEM_OWNER_NAME --}}
                <x-form.label for="budget_owner_name" :value="__('budgets.input-budget-owner-name')" />
                <x-form.input id="budget_owner_name" name="budget_owner_name" type="text" disabled
                    class="block w-full" />
                <x-form.error :messages="$errors->get('order_at')" />
            </section>
            <section class="grid grid-cols-2 gap-2">
                <section class="space-y-2"> {{-- BUDGET_ITEM_OWNER_POSITION --}}
                    <x-form.label for="budget_owner_position" :value="__('budgets.input-budget-owner-position')" />
                    <x-form.input id="budget_owner_position" name="budget_owner_position" type="text" disabled
                        class="block w-full" />
                    <x-form.error :messages="$errors->get('order_at')" />
                </section>
                <section class="space-y-2"> {{-- BUDGET_ITEM_OWNER_AFFILIATION --}}
                    <x-form.label for="budget_owner_affiliation" :value="__('budgets.input-budget-owner-affiliation')" />
                    <x-form.input id="budget_owner_affiliation" name="budget_owner_affiliation" type="text" disabled
                        class="block w-full" />
                    <x-form.error :messages="$errors->get('order_at')" />
                </section>
            </section>
            <section class="space-y-2"> {{-- HEADER --}}
                <x-form.label for="header" :value="__('budgets.input-header')" />
                <x-form.input id="header" :placeholder="__('budgets.input-header-placeholder')" name="header"
                    type="text" class="block w-full" />
            </section>
            <section class="space-y-2"> {{-- SUBJECT --}}
                <x-form.label for="subject" :value="__('budgets.input-subject')" />
                <x-form.input id="subject" wire:model="subject" name="subject" :placeholder="__('budgets.input-subject-placeholder')" type="text"
                    class="block w-full" />
                <x-form.error :messages="$errors->get('subject')" />
            </section>
        </section>
        <section class="max-w-full col-span-2 flex justify-end">
            <x-button type="submit" variant="success">บันทึกใบเบิก</x-button>
        </section>
    </form>
</section>
