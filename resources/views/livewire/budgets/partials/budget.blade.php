<section class="grid grid-cols-2 gap-1">
    <x-textfield :label="__('budgets.input-office')" wire:model="budgetForm.office" disabled />
    <x-textfield :label="__('budgets.input-invitation')" wire:model="budgetForm.invitation" disabled />
    <x-textfield :label="__('budgets.input-serial')" wire:model="budgetForm.serial" disabled />
    <x-textfield :label="__('budgets.input-name')" wire:model="budgetForm.name" disabled />
</section>
