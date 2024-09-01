@props([
    'target' => '',
    'name' => 'confirmation',
    'header' => '',
    'text' => '',
    'variant' => 'success',
])

<section x-data="{ target: @js($target), name: @js($name), header: @js($header), text: @js($text) }"
    x-on:confirmation.window="() => {
        target = $event.detail.target;
        text = $event.detail.text;
        if ($event.detail.header) header = $event.detail.header;
        $dispatch('open-modal', name);
    }">
    <x-modal name="{{ $name }}" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium" x-text="header"></h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" x-text="text"></p>

            <div class="mt-6 flex justify-end">
                <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('confirmation.cancel') }}
                </x-button>

                <x-button type="submit" x-bind:form="target" :variant="$variant" class="ml-3">
                    {{ __('confirmation.confirm') }}
                </x-button>
            </div>
        </div>
    </x-modal>
</section>
