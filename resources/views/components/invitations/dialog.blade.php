@props([
    'method' => 'post',
    'route' => route('invitations.store'),
    'value' => '',
    'checked' => false
])

<section x-data="{ method: @js($method), route: @js($route), value: @js($value), text: @js(__('invitations.dialog-title')), checked: @js($checked) }"
    x-on:dialog.window="() => {
    method = $event.detail.method;
    route = $event.detail.route;
    value = $event.detail.value;
    checked = $event.detail.checked;
    text = method == 'post' ? @js(__('invitations.dialog-create-title')) : @js(__('invitations.dialog-update-title'));
    $dispatch('open-modal', 'invitation-form');
}">
    <x-modal name="invitation-form" focusable maxWidth="md" :show="$errors->storeInvitation->isNotEmpty()">
        <form method="post" x-bind:action="route" class="p-6">
            @csrf
            <input type="hidden" :value="method" name="_method">

            <h2 class="text-lg font-medium" x-text="text"></h2>

            <div class="mt-6 space-y-6">
                <x-form.label for="label" value="Password" class="sr-only" />

                <x-form.input id="label" x-bind:value="value" name="label" type="text"
                    class="block w-full" placeholder="{{ __('invitations.dialog-input-invitation') }}" />

                <x-form.error :messages="$errors->storeInvitation->get('label')" />

                <div class="flex items-center justify-between">
                    <label for="use_default" class="inline-flex items-center">
                        <input id="use_default" type="checkbox"
                            x-bind:checked="checked"
                            class="text-primary border-gray-300 rounded focus:border-primary-300 focus:ring focus:ring-primary dark:border-gray-600 dark:bg-dark-eval-1 dark:focus:ring-offset-dark-eval-1"
                            name="default">

                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('invitations.dialog-input-default') }}
                        </span>
                    </label>
                </div>
                <x-form.error :messages="$errors->storeInvitation->get('default')" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('invitations.dialog-cancel-btn') }}
                </x-button>

                <x-button variant="primary" class="ml-3">
                    {{ __('invitations.dialog-save-btn') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>
