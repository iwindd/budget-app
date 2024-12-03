<section
    x-data="{
        'role': @entangle('role'),
        'name': @entangle('name'),
        'position': @entangle('position'),
        'affiliation': @entangle('affiliation'),
        'email': @entangle('email'),
    }"
    x-on:open-users-dialog.window = "() => {
        const data = $event.detail

        role = data?.role || role;
        name = data?.name || name;
        position = data['position.id'] || position;
        affiliation = data['affiliation.id'] || affiliation;
        email = data?.email || email;

        if (data['users.id']) $wire.onOpenDialog(data['users.id']);
        $dispatch('open-modal', 'users-form');
    }"
>
    <x-modal name="users-form" focusable maxWidth="md">
        <form class="p-6" wire:submit="submit">
            <h2 class="text-lg font-medium">{{ __('users.dialog-title')  }}</h2>

            <div class="mt-6 space-y-2">
                <x-textfield
                    :label="__('auth.name')"
                    :startIcon="@svg('heroicon-o-user')"
                    wire:model="name"
                    type="text"
                />

                <div class="grid grid-cols-2 gap-2">
                    <x-selectize
                        :fetch="route('positions.selectize')"
                        lang='positions.selectize'
                        wire:model="position"
                        :selectOnClose="true"
                        :parseInt="false"
                        :parseCreate="true"
                        create
                    />
                    <x-selectize
                        :fetch="route('affiliations.selectize')"
                        lang='affiliations.selectize'
                        wire:model="affiliation"
                        :selectOnClose="true"
                        :parseInt="false"
                        :parseCreate="true"
                        create
                    />
                </div>

                <x-textfield
                    :label="__('auth.email')"
                    :startIcon="@svg('heroicon-o-envelope')"
                    wire:model="email"
                    type="email"
                />

                <x-selectize
                    lang='users.table-role'
                    wire:model="role"
                    :selectOnClose="true"
                    :parseInt="false"
                    :options="[
                        ['label' => __('users.table-role-user'), 'id' => 'user'],
                        ['label' => __('users.table-role-admin'), 'id' => 'admin'],
                        ['label' => __('users.table-role-banned'), 'id' => 'banned'],
                    ]"
                />
            </div>

            <p class="text-xs text-danger">* ผู้ใช้ที่ถูกสร้างขึ้นใหม่รหัสผ่านจะถูกใช้ว่า <strong>password</strong> จนกว่าผู้ใช้จะเปลี่ยนแปลง</p>

            <div class="mt-6 flex justify-end">
                <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('users.dialog-cancel-btn') }}
                </x-button>

                <x-button variant="primary" class="ml-3" >
                    {{ __('users.dialog-save-btn') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>
