<section
    x-data="{
        label: @entangle('office.label'),
        province: @entangle('office.province'),
        checked: @entangle('office.default'),
    }"
    x-on:open-office-dialog.window = "() => {
        const data = $event.detail
        label = data?.label || label;
        province = data?.province || province;
        checked = data?.default || checked;

        if (data.id) $wire.onOpenDialog(data.id);

        $dispatch('open-modal', 'office-form');
    }"
>
    <x-modal name="office-form" focusable maxWidth="md">
        <form class="p-6" wire:submit="submit">
            <h2 class="text-lg font-medium">{{ __('offices.dialog-title')  }}</h2>

            <div class="mt-6 space-y-2">
                <x-textfield :startIcon="@svg('heroicon-o-building-office')" lang="offices.dialog-input-office" wire:model="office.label" autofocus/>
                <x-selectize :options="$provinces" lang="budgets.input-name" wire:model="office.province" display="name_th"  defaultValue="67" />
                <x-checkbox :label="__('offices.dialog-input-default')" wire:model="office.default" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('offices.dialog-cancel-btn') }}
                </x-button>

                <x-button variant="primary" class="ml-3" >
                    {{ __('offices.dialog-save-btn') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>
