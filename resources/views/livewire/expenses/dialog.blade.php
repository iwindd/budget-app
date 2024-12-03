<section
    x-data="{
        label: @entangle('expense.label')
    }"
    x-on:open-expense-dialog.window = "() => {
        const data = $event.detail
        label = data?.label || label;

        if (data.id) $wire.onOpenDialog(data.id);

        $dispatch('open-modal', 'expense-form');
    }"
>
    <x-modal name="expense-form" focusable maxWidth="md">
        <form class="p-6" wire:submit="submit">
            <h2 class="text-lg font-medium">{{ __('expenses.dialog-title')  }}</h2>

            <div class="mt-6 space-y-2">
                <x-textfield :startIcon="@svg('heroicon-o-banknotes')" lang="expenses.dialog-input-expense" wire:model="expense.label" autofocus/>
            </div>

            <div class="mt-6 flex justify-end">
                <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('expenses.dialog-cancel-btn') }}
                </x-button>

                <x-button variant="primary" class="ml-3" >
                    {{ __('expenses.dialog-save-btn') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>
