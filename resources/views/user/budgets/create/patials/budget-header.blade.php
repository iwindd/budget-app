<section class="space-y-2">
    <header>
        <h3 class="font-bold">ส่วนหัว</h3>
    </header>
    <section class="grid grid-cols-2 gap-2">
        <section class="space-y-2">
            <x-form.label for="serial" :value="__('budgets.input-serial')" />

            <x-form.input id="serial" value="{{ $serial }}" disabled name="serial" type="text"
                class="block w-full"/>

            <x-form.error :messages="$errors->upsertBudget->get('serial')" />
        </section>
        <section class="space-y-2">
            <x-form.label for="date" :value="__('budgets.input-date')" />

            <x-form.input id="date" name="date" type="date" :value="old('date', date('Y-m-d'))"  class="block w-full" autocomplete="new-date" />

            <x-form.error :messages="$errors->upsertBudget->get('date')" />
        </section>
        <section class="space-y-2">
            <x-form.label :value="__('budgets.input-name')" />

            <x-form.input id="name" value="{{ Auth::user()->name }}" disabled type="text"
                class="block w-full" />
        </section>
        <section class="space-y-2">
            <x-form.label for="value" :value="__('budgets.input-value')" />

            <x-form.input id="value" name="value" type="number" :value="old('value')" class="block w-full" :placeholder="__('budgets.input-value-placeholder')" autocomplete="new-value" />

            <x-form.error :messages="$errors->upsertBudget->get('value')" />
        </section>
    </section>
</section>
