@props([
    'method' => "post",
    'route'  => route('positions.store'),
    'value' => ""
])

<section  x-data="{ method: @js($method), route: @js($route), value: @js($value), text: @js(__('positions.dialog-title')) }"
x-on:dialog.window="() => {
    method = $event.detail.method;
    route = $event.detail.route;
    value = $event.detail.value;
    text = method == 'post' ? @js(__('positions.dialog-create-title')) : @js(__('positions.dialog-update-title'));
    $dispatch('open-modal', 'position-form');
}">
    <x-modal name="position-form" focusable maxWidth="md" :show="$errors->storePosition->isNotEmpty()">
        <form method="post" x-bind:action="route" class="p-6">
            @csrf
            <input type="hidden" :value="method" name="_method">

            <h2 class="text-lg font-medium" x-text="text"></h2>

            <div class="mt-6 space-y-6">
                <x-form.label for="label" value="Password" class="sr-only" />

                <x-form.input id="label" x-bind:value="value" name="label" type="text" class="block w-full"
                    placeholder="{{__('positions.dialog-input-position')}}" />

                <x-form.error :messages="$errors->storePosition->get('label')" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('positions.dialog-cancel-btn') }}
                </x-button>

                <x-button variant="primary" class="ml-3">
                    {{ __('positions.dialog-save-btn') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>
