<section
    x-data="{
        label: @entangle('position.label'),
    }"
    x-on:open-position-dialog.window = "() => {
        const data = $event.detail
        label = data?.label || label;

        if (data.id) $wire.onOpenDialog(data.id);

        $dispatch('open-modal', 'position-form');
    }"
>
    <x-modal name="position-form" focusable maxWidth="md">
        <form class="p-6" wire:submit="submit">
            <h2 class="text-lg font-medium">{{ __('positions.dialog-title')  }}</h2>

            <div class="mt-6 space-y-2">
                <x-textfield :startIcon="@svg('heroicon-o-check-badge')" lang="positions.dialog-input-position" wire:model="position.label" autofocus/>
            </div>

            <div class="mt-6 flex justify-end">
                <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('positions.dialog-cancel-btn') }}
                </x-button>

                <x-button variant="primary" class="ml-3" >
                    {{ __('positions.dialog-save-btn') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>
