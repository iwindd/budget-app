<section>
    <x-modal name="find-budget-form" focusable maxWidth="md" :show="$errors->findBudget->isNotEmpty()">
        <form class="p-6" wire:submit="submit">
            <h2 class="text-lg font-medium">{{ __('budgets.admin-add-dialog-header') }}</h2>

            <section class="space-y-2 mt-6">
                <div class="space-y-2">
                    <x-textfield
                        :startIcon="@svg('heroicon-o-hashtag')"
                        :disabled="$infoStep"
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

                @if ($infoStep)
                    <div class="grid grid-cols-2 gap-2">
                        <x-textfield
                            :startIcon="@svg('heroicon-o-calendar')"
                            wire:model="budgetForm.date"
                            lang="budgets.input-date"
                            type="date"
                        />
                        <x-textfield
                            :startIcon="@svg('heroicon-o-banknotes')"
                            :placeholder="__('budgets.input-value-placeholder')"
                            wire:model="budgetForm.value"
                            lang="budgets.input-value-minimize"
                        />
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
