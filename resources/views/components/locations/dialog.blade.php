@props([
    'method' => "post",
    'route'  => route('locations.store'),
    'value' => ""
])

<section  x-data="{ method: @js($method), route: @js($route), value: @js($value), text: @js(__('locations.dialog-title')) }"
x-on:dialog.window="() => {
    method = $event.detail.method;
    route = $event.detail.route;
    value = $event.detail.value;
    text = method == 'post' ? @js(__('locations.dialog-create-title')) : @js(__('locations.dialog-update-title'));
    $dispatch('open-modal', 'location-form');
}">
    <x-modal name="location-form" focusable maxWidth="md" :show="$errors->storelocation->isNotEmpty()">
        <form method="post" x-bind:action="route" class="p-6">
            @csrf
            <input type="hidden" :value="method" name="_method">

            <h2 class="text-lg font-medium" x-text="text"></h2>

            <div class="mt-6 space-y-6">
                <x-form.label for="label" value="Password" class="sr-only" />

                <x-form.input id="label" x-bind:value="value" name="label" type="text" class="block w-full"
                    placeholder="{{__('locations.dialog-input-location')}}" />

                <x-form.error :messages="$errors->storelocation->get('label')" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('locations.dialog-cancel-btn') }}
                </x-button>

                <x-button variant="primary" class="ml-3">
                    {{ __('locations.dialog-save-btn') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>
