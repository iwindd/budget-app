<section class="space-y-2">
    <header>
        <h3 class="font-bold">รายละเอียด</h3>
    </header>

    <livewire:budgets.address-patial :errors="$errors->getBag('upsertBudget')->toArray()" :old="old('address')"/>
</section>
