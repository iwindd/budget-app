<section
    x-data="{
        label: @entangle('location.label'),
    }"
    x-on:open-location-dialog.window = "() => {
        const data = $event.detail
        label = data?.label || label;

        if (data.id) $wire.onOpenDialog(data.id);

        $dispatch('open-modal', 'location-form');
    }"
>
    <x-modal name="location-form" focusable maxWidth="md">
        <form class="p-6" wire:submit="submit">
            <h2 class="text-lg font-medium">{{ __('locations.dialog-title')  }}</h2>

            <div class="mt-6 space-y-2">
                <x-textfield :startIcon="@svg('heroicon-o-map-pin')" lang="locations.dialog-input-location" wire:model="location.label" autofocus/>
            </div>

            <div class="mt-6 flex justify-end">
                <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('locations.dialog-cancel-btn') }}
                </x-button>

                <x-button variant="primary" class="ml-3" >
                    {{ __('locations.dialog-save-btn') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>
