<section
    x-data="{
        label: @entangle('affiliation.label'),
    }"
    x-on:open-affiliation-dialog.window = "() => {
        const data = $event.detail
        label = data?.label || label;

        if (data.id) $wire.onOpenDialog(data.id);

        $dispatch('open-modal', 'affiliation-form');
    }"
>
    <x-modal name="affiliation-form" focusable maxWidth="md">
        <form class="p-6" wire:submit="submit">
            <h2 class="text-lg font-medium">{{ __('affiliations.dialog-title')  }}</h2>

            <div class="mt-6 space-y-2">
                <x-textfield :startIcon="@svg('heroicon-o-tag')" lang="affiliations.dialog-input-affiliation" wire:model="affiliation.label" autofocus/>
            </div>

            <div class="mt-6 flex justify-end">
                <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('affiliations.dialog-cancel-btn') }}
                </x-button>

                <x-button variant="primary" class="ml-3" >
                    {{ __('affiliations.dialog-save-btn') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>
