<x-modal name="position-form" focusable maxWidth="md" :show="$errors->storePosition->isNotEmpty()">
    <form method="post" action="{{ route('positions.store') }}" class="p-6">
        @csrf
        @method('post')

        <h2 class="text-lg font-medium">
            {{ __('positions.dialog-title') }}
        </h2>

        <div class="mt-6 space-y-6">
            <x-form.label for="label" value="Password" class="sr-only" />

            <x-form.input id="label" name="label" type="text" class="block w-full"
                placeholder="{{__('positions.dialog-input-position')}}" />

            <x-form.error :messages="$errors->storePosition->get('label')" />
        </div>

        <div class="mt-6 flex justify-end">
            <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                {{ __('positions.dialog-cancel-btn') }}
            </x-button>

            <x-button variant="primary" class="ml-3">
                {{ __('positions.dialog-add-btn') }}
            </x-button>
        </div>
    </form>
</x-modal>
