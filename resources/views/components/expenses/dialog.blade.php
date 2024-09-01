@props([
    'method' => "post",
    'route'  => route('expenses.store'),
    'value' => ""
])

<section  x-data="{ method: @js($method), route: @js($route), value: @js($value), text: @js(__('expenses.dialog-title')) }"
x-on:dialog.window="() => {
    method = $event.detail.method;
    route = $event.detail.route;
    value = $event.detail.value;
    text = method == 'post' ? @js(__('expenses.dialog-create-title')) : @js(__('expenses.dialog-update-title'));
    $dispatch('open-modal', 'expense-form');
}">
    <x-modal name="expense-form" focusable maxWidth="md" :show="$errors->storeExpense->isNotEmpty()">
        <form method="post" x-bind:action="route" class="p-6">
            @csrf
            <input type="hidden" :value="method" name="_method">

            <h2 class="text-lg font-medium" x-text="text"></h2>

            <div class="mt-6 space-y-6">
                <x-form.label for="label" value="Password" class="sr-only" />

                <x-form.input id="label" x-bind:value="value" name="label" type="text" class="block w-full"
                    placeholder="{{__('expenses.dialog-input-expense')}}" />

                <x-form.error :messages="$errors->storeExpense->get('label')" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('expenses.dialog-cancel-btn') }}
                </x-button>

                <x-button variant="primary" class="ml-3">
                    {{ __('expenses.dialog-save-btn') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>
