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
                <x-form.input id="budgetForm.invitation" name="budgetForm.invitation" wire:model="budgetForm.invitation"
                    disabled type="text" class="block w-full" />
            </section>
            <section class="space-y-2"> {{-- SERIAL --}}
                <x-form.label for="budgetForm.serial" :value="__('budgets.input-serial')" />
                <x-form.input id="budgetForm.serial" wire:model="budgetForm.serial" disabled name="serial"
                    type="text" class="block w-full" />
                <x-form.error :messages="$errors->get('budgetForm.serial')" />
            </section>
            <section class="space-y-2"> {{-- NAME --}}
                <x-form.label for="budgetForm.name" :value="__('budgets.input-name')" />
                <x-form.input id="budgetForm.name" name="budgetForm.name" disabled type="text"
                    wire:model="budgetForm.name" class="block w-full" />
            </section>
            <section class="space-y-2 md:col-span-1 col-span-2"> {{-- DATE --}}
                <x-form.label for="budgetForm.date" :value="__('budgets.input-date')" />
                <x-form.input id="budgetForm.date" name="budgetForm.date" type="date" wire:model="budgetForm.date"
                    class="block w-full" disabled="{{!$hasPermissionToManage}}"/>
                <x-form.error :messages="$errors->get('budgetForm.date')" />
            </section>
            <section class="space-y-2 md:col-span-1 col-span-2"> {{-- VALUE --}}
                <x-form.label for="budgetForm.value" :value="__('budgets.input-value')" />
                <x-form.input id="budgetForm.value" disabled="{{!$hasPermissionToManage}}" name="value" type="number" wire:model="budgetForm.value"
                    class="block w-full" :placeholder="__('budgets.input-value-placeholder')" />
                <x-form.error :messages="$errors->get('budgetForm.value')" />
            </section>
        </section>
    </div>
</div>
