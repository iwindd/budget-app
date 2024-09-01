@props([
    'method' => "post",
    'route'  => route('affiliations.store'),
    'value' => ""
])

<section  x-data="{ method: @js($method), route: @js($route), value: @js($value), text: @js(__('affiliations.dialog-title')) }"
x-on:dialog.window="() => {
    method = $event.detail.method;
    route = $event.detail.route;
    value = $event.detail.value;
    text = method == 'post' ? @js(__('affiliations.dialog-create-title')) : @js(__('affiliations.dialog-update-title'));
    $dispatch('open-modal', 'affiliation-form');
}">
    <x-modal name="affiliation-form" focusable maxWidth="md" :show="$errors->storeAffiliation->isNotEmpty()">
        <form method="post" x-bind:action="route" class="p-6">
            @csrf
            <input type="hidden" :value="method" name="_method">

            <h2 class="text-lg font-medium" x-text="text"></h2>

            <div class="mt-6 space-y-6">
                <x-form.label for="label" value="Password" class="sr-only" />

                <x-form.input id="label" x-bind:value="value" name="label" type="text" class="block w-full"
                    placeholder="{{__('affiliations.dialog-input-affiliation')}}" />

                <x-form.error :messages="$errors->storeAffiliation->get('label')" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('affiliations.dialog-cancel-btn') }}
                </x-button>

                <x-button variant="primary" class="ml-3">
                    {{ __('affiliations.dialog-save-btn') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>
