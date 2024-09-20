<section class="space-y-2">
    <header>
        <h3 class="font-bold">รายละเอียด</h3>
    </header>
    <section class="grid grid-cols-2 gap-2">
        <section class="space-y-2">
            <x-form.label for="header" :value="__('budgets.input-header')" />

            <x-form.input id="header" value="ขออนุมัติเบิกค่าใช้จ่ายในการเดินทางไปราชการ" disabled name="header" type="text" class="block w-full"/>
        </section>
        <section class="space-y-2">
            <x-form.label for="office" :value="__('budgets.input-office')" />

            <x-form.input id="office" :value="$office" disabled name="office" type="text" class="block w-full"/>
        </section>
        <section class="space-y-2">
            <x-form.label for="invitation" :value="__('budgets.input-invitation')" />

            <x-form.input id="invitation" :value="$invitation" disabled name="invitation" type="text" class="block w-full"/>
        </section>
        <section class="space-y-2">
            <x-form.label for="date" :value="__('budgets.input-date')" />

            <x-form.input id="order_at" name="order_at" type="date" :value="old('order_at', date('Y-m-d'))" class="block w-full" autocomplete="new-order_at" />

            <x-form.error :messages="$errors->upsertBudget->get('order_at')" />
        </section>
        <section class="space-y-2">
            <x-form.label for="title" :value="__('budgets.input-title')" />

            <x-form.input id="title" name="title" :placeholder="__('budgets.input-title-placeholder')" type="text" class="block w-full" autocomplete="new-title" />

            <x-form.error :messages="$errors->upsertBudget->get('title')" />
        </section>
        <section class="space-y-2">
            <x-form.label for="companions" :value="__('budgets.input-companions')" />

            <x-budgets.create.companion-selector />
        </section>
    </section>
</section>
