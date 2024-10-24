@props([
    'variant' => 'primary',
    'text' => '',
    'title' => '',
])

<section x-data="{
    show: false,
    variant: @js($variant),
    title: @js($title),
    text: @js($text),
    confirm: null,
    cancel: null,
    submit() {
        this.show = false;
        if (this.confirm) this.confirm();

        this.confirm = null;
        this.cancel = null;
    },
    close() {
        this.show = false;
        if (this.cancel) this.cancel();

        this.confirm = null;
        this.cancel = null;
    },
    focusables() {
        // All focusable element types...
        let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
        return [...$el.querySelectorAll(selector)]
            // All non-disabled elements...
            .filter(el => !el.hasAttribute('disabled'))
    },
    firstFocusable() { return this.focusables()[0] },
    lastFocusable() { return this.focusables().slice(-1)[0] },
    nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
    prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
    nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
    prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1 },
}"
    x-on:confirmation.window="() => {
        text = $event.detail.text;
        if ($event.detail.title) title = $event.detail.title;
        if ($event.detail.confirm) confirm = $event.detail.confirm;
        if ($event.detail.cancel) cancel = $event.detail.cancel;
        if ($event.detail.variant) variant = $event.detail.variant;
        show = true;
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
            {{ $attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100)' : '' }}
        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })" x-on:keydown.escape.window="close()"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()" x-show="show"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" style="display: 'none'">
    {{-- BACKDROP --}}
    <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="close()"
        x-transition:enter="ease-out duration-50" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-out duration-50"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    {{-- CONTENT --}}
    <div x-show="show"
        class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-md sm:mx-auto"
        x-transition:enter="ease-out duration-50" x-transition:enter-start="opacity-0 translate-y-[-20px]"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="ease-out duration-50"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-[-20px]">
        <div class="p-6">
            <h2 class="text-lg font-medium" x-text="title"></h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" x-text="text"></p>

            <div class="mt-6 flex justify-end">
                <x-button type="button" variant="secondary" x-on:click="close">
                    {{ __('confirmation.cancel') }}
                </x-button>

                <x-button type="button" x-on:click="submit" x-bind:variant="variant" class="ml-3">
                    {{ __('confirmation.confirm') }}
                </x-button>
            </div>
        </div>
    </div>
</section>
