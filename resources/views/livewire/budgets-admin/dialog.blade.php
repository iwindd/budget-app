<section>
    <x-modal name="find-budget-form" focusable maxWidth="md" :show="$errors->findBudget->isNotEmpty()">
        <form class="p-6" wire:submit="submit">
            <h2 class="text-lg font-medium">{{ __('budgets.admin-add-dialog-header') }}</h2>

            <section class="space-y-2 mt-6">
                <div class="space-y-2">
                    <x-textfield
                        :startIcon="@svg('heroicon-o-hashtag')"
                        wire:model="serial"
                        lang="budgets.input-serial"
                    />
                </div>

                <div class="space-y-2">
                    <x-selectize
                        :fetch="route('companions.selectize')"
                        lang="budgets.input-name"
                        wire:model="user_id"
                        display="name"
                    />
                </div>
            </section>

            <div class="mt-6 flex justify-end">
                <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('budgets.dialog-cancel-btn') }}
                </x-button>

                <x-button variant="primary" type="submit" class="ml-3">
                    {{ __('budgets.add-btn') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>
