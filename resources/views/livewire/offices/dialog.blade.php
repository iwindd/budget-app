<section>
    <x-modal name="office-form" focusable maxWidth="md">
        <form class="p-6" wire:submit="submit">
            <h2 class="text-lg font-medium">{{ $office->office->label ?? __('offices.dialog-create-title') }}</h2>

            <div class="mt-6 space-y-2">
                <section>
                    <x-form.label for="label" value="{{ __('offices.dialog-input-office') }}" class="sr-only" />
                    <x-form.input wire:model='office.label' name="label" type="text" class="block w-full"
                        placeholder="{{ __('offices.dialog-input-office') }}" />
                    <x-form.error :messages="$errors->get('office.label')" />
                </section>

                <section>
                    <x-selectize
                        :options="$provinces"
                        lang="budgets.input-name"
                        wire:model="office.province"
                        display="name_th"
                    />
                </section>

                <section class="flex items-center justify-between">
                    <label for="office.default" class="inline-flex items-center">
                        <input id="office.default" wire:model='office.default' type="checkbox"
                            class="text-primary border-gray-300 rounded focus:border-primary-300 focus:ring focus:ring-primary dark:border-gray-600 dark:bg-dark-eval-1 dark:focus:ring-offset-dark-eval-1"
                            name="office.default">
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('offices.dialog-input-default') }}
                        </span>
                    </label>
                </section>
                <x-form.error :messages="$errors->get('office.default')" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('offices.dialog-cancel-btn') }}
                </x-button>

                <x-button variant="primary" class="ml-3">
                    {{ __('offices.dialog-save-btn') }}
                </x-button>
            </div>
        </form>
    </x-modal>

    @script
        <script>
            window.addEventListener('CreateOfficeDialog', () => $dispatch('open-modal', 'office-form'));
        </script>
    @endscript
</section>
