<section
    x-data="{
        label: @entangle('invitation.label'),
        checked: @entangle('invitation.default'),
    }"
    x-on:open-invitation-dialog.window = "() => {
        const data = $event.detail
        label = data?.label || label;
        checked = data?.default || checked;

        if (data.id) {
        console.log('dsadsa');
        $wire.onOpenDialog(data.id);
        }

        $dispatch('open-modal', 'invitation-form');
    }"
>
    <x-modal name="invitation-form" focusable maxWidth="md">
        <form class="p-6" wire:submit="submit">
            <h2 class="text-lg font-medium">{{ __('invitations.dialog-title')  }}</h2>

            <div class="mt-6 space-y-2">
                <x-textfield :startIcon="@svg('heroicon-o-user-plus')" lang="invitations.dialog-input-invitation" wire:model="invitation.label" autofocus/>
                <x-checkbox
                    :disabled="$invitation->invitation->default ?? false"
                    :label="__('invitations.dialog-input-default')"
                    wire:model="invitation.default"
                />
            </div>

            <div class="mt-6 flex justify-end">
                <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('invitations.dialog-cancel-btn') }}
                </x-button>

                <x-button variant="primary" class="ml-3" >
                    {{ __('invitations.dialog-save-btn') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>
