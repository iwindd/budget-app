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
                    <section wire:ignore>
                        <select id="province-selector"></select>
                    </section>
                    <x-form.error :messages="$errors->get('office.province')" />
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
            const provinces = (@js($provinces)).map(p => ({
                id: p.id,
                text: p.name_th
            }));

            const setProvince = (id) => {
                $("#province-selector").val(id);
                $("#province-selector").trigger('change');
            }

            $(document).ready(function(e) {
                $('#province-selector').select2({
                    width: '100%',
                    data: provinces,
                    placeholder: @js(__('budgets.input-companion-placeholder')),
                });

                $('#province-selector').on('select2:select', (e) => $dispatch('selectedProvince', {
                    id: e.params.data.id
                }));

                setProvince(67);
            })

            window.addEventListener('setProvince', (data) => setProvince(data.detail[0]));
            window.addEventListener('CreateOfficeDialog', () => {
                $dispatch('open-modal', 'office-form');
                setProvince(67);
            });
        </script>
    @endscript
</section>
