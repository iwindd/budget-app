<section>
    <form wire:submit="save" class="grid grid-cols-2 gap-2">
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
            <x-form.input id="value" name="value" type="number" wire:model="value" class="block w-full"  :disabled="!$isOwner" :placeholder="__('budgets.input-value-placeholder')" />
            <x-form.error :messages="$errors->get('value')" />
        </section>
        <hr class="col-span-2 my-3">
        <section class="space-y-2"> {{-- HEADER --}}
            <x-form.label for="header" :value="__('budgets.input-header')" />
            <x-form.input id="header" value="{{ __('budgets.input-subject') }}" disabled name="header"
                type="text" class="block w-full" />
        </section>
        <section class="space-y-2"> {{-- OFFICE --}}
            <x-form.label for="office" :value="__('budgets.input-office')" />
            <x-form.input id="office" :value="$office" disabled name="office" type="text" class="block w-full" />
        </section>
        <section class="space-y-2"> {{-- INVITATION --}}
            <x-form.label for="invitation" :value="__('budgets.input-invitation')" />
            <x-form.input id="invitation" :value="$invitation" disabled name="invitation" type="text" class="block w-full" />
        </section>
        <section class="space-y-2"> {{-- ORDER_AT --}}
            <x-form.label for="date" :value="__('budgets.input-date')" />
            <x-form.input id="order_at" name="order_at" type="date" :disabled="!$isOwner" wire:model="order_at"
                class="block w-full" />
            <x-form.error :messages="$errors->get('order_at')" />
        </section>
        <section class="space-y-2"> {{-- TITLE --}}
            <x-form.label for="title" :value="__('budgets.input-title')" />
            <x-form.input id="title" wire:model="title" :disabled="!$isOwner" name="title" :placeholder="__('budgets.input-title-placeholder')"
                type="text" class="block w-full" />
            <x-form.error :messages="$errors->get('title')" />
        </section>
        <section class="space-y-2"> {{-- PLACE --}}
            <x-form.label for="place" :value="__('budgets.input-place')" />
            <x-form.input id="place" wire:model="place" :disabled="!$isOwner" name="place" :placeholder="__('budgets.input-place-placeholder')"
                type="text" class="block w-full" />
            <x-form.error :messages="$errors->get('place')" />
        </section>
        <section class="max-w-full col-span-2 flex justify-end">
            <x-button type="submit" variant="success">บันทึกใบเบิก</x-button>
        </section>
    </form>
</section>
