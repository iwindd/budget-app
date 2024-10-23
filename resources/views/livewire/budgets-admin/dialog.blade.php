<section>
    <x-modal name="find-budget-form" focusable maxWidth="md" :show="$errors->findBudget->isNotEmpty()">
        <form class="p-6" wire:submit="submit">
            <h2 class="text-lg font-medium">{{ __('budgets.admin-add-dialog-header') }}</h2>

            <section class="space-y-2 mt-6">
                <div class="space-y-2">
                    <x-form.label for="serial" value="{{ __('budgets.input-serial') }}" />
                    <x-form.input id="serial" :disabled="$infoStep" wire:model="serial" type="text"
                        class="block w-full" />
                    <x-form.error :messages="$errors->get('serial')" />
                </div>

                <div class="space-y-2">
                    <x-selectize
                        :fetch="route('companions.selectize')"
                        lang="budgets.input-name"
                        wire:model="user_id"
                        display="name"
                    />
                </div>

                @if ($infoStep)
                    <div class="grid grid-cols-2 gap-2">
                        <div class="space-y-2">
                            <x-form.label for="budgetForm.date" :value="__('budgets.input-date')" />
                            <x-form.input id="budgetForm.date" wire:model="budgetForm.date" name="budgetForm.date"
                                type="date" class="block w-full" />
                            <x-form.error :messages="$errors->get('budgetForm.date')" />
                        </div>
                        <div class="space-y-2 ">
                            <x-form.label for="budgetForm.value" :value="__('budgets.input-value-minimize')" />
                            <x-form.input id="budgetForm.value" name="budgetForm.value" type="number"
                                wire:model="budgetForm.value" class="block w-full" :placeholder="__('budgets.input-value-placeholder')" />
                            <x-form.error :messages="$errors->get('budgetForm.value')" />
                        </div>
                    </div>
                @endif
            </section>

            <div class="mt-6 flex justify-end">
                @if ($infoStep)
                    <x-button type="button" variant="secondary" class="mr-auto" wire:click="clear">
                        {{ __('budgets.dialog-back-btn') }}
                    </x-button>
                @endif

                <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('budgets.dialog-cancel-btn') }}
                </x-button>

                <x-button variant="primary" type="submit" class="ml-3">
                    {{ __('budgets.dialog-confirm-btn') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>
