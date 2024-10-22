<x-modal name="find-budget-form" focusable maxWidth="md" :show="$errors->findBudget->isNotEmpty()">
    <form class="p-6" method="post" action="{{ route('budgets.find') }}">
        @csrf
        <h2 class="text-lg font-medium">{{__('budgets.input-serial')}}</h2>

        <div class="mt-6 space-y-6">
            <x-textfield
                :error="$errors->findBudget->get('serial')"
                type="text"
                id="serial"
                name="serial"
                required
                autofocus
            />
        </div>

        <div class="mt-6 flex justify-end">
            <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                {{ __('budgets.dialog-cancel-btn') }}
            </x-button>

            <x-button variant="primary" class="ml-3">
                {{ __('budgets.dialog-confirm-btn') }}
            </x-button>
        </div>
    </form>
</x-modal>
