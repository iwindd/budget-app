<section>
    <x-modal name="find-budget-form" focusable maxWidth="md" :show="$errors->findBudget->isNotEmpty()">
        <form class="p-6" wire:submit="submit">
            <h2 class="text-lg font-medium">{{ __('budgets.admin-add-dialog-header') }}</h2>

            <section class="space-y-2 mt-6">
                <div class="space-y-2">
                    <x-form.label for="serial" value="{{ __('budgets.input-serial') }}" />
                    <x-form.input id="serial" :disabled="$isNew" wire:model="serial" type="text"
                        class="block w-full" />
                    <x-form.error :messages="$errors->get('serial')" />
                </div>

                <div class="space-y-2 {{!$isNew ?'hidden' : ''}}"> {{-- ถ้าใช้ if ครอบ event จะไม่ทำงาน --}}
                    <x-form.label :value="__('budgets.input-name')" />
                    <select wire:model="user" id="user-selector" class="w-full">
                        @isset($user_id)
                            @isset($user_label)
                                <option value="{{ $user_id }}" selected>{{ $user_label }}</option>
                            @endisset
                        @endisset
                    </select>
                    <x-form.error :messages="$errors->get('user')" />
                </div>

                @if ($isNew)
                    <div class="grid grid-cols-2 gap-2">
                        <div class="space-y-2">
                            <x-form.label for="title" :value="__('budgets.input-title')" />
                            <x-form.input id="title" wire:model="title" name="title" :placeholder="__('budgets.input-title-placeholder')"
                                type="text" class="block w-full" />
                            <x-form.error :messages="$errors->get('title')" />
                        </div>
                        <div class="space-y-2">
                            <x-form.label for="place" :value="__('budgets.input-place')" />
                            <x-form.input id="place" wire:model="place" name="place" :placeholder="__('budgets.input-place-placeholder')"
                                type="text" class="block w-full" />
                            <x-form.error :messages="$errors->get('place')" />
                        </div>
                        <div class="space-y-2 col-span-2">
                            <x-form.input id="value" name="value" type="number" wire:model="value"
                                class="block w-full" :placeholder="__('budgets.input-value-placeholder')" />
                            <x-form.error :messages="$errors->get('value')" />
                        </div>
                    </div>
                @endif
            </section>

            <div class="mt-6 flex justify-end">
                @if ($isNew)
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

    @script
        <script>
            $(document).ready(function(e) {
                window.initSelectors = () => {
                    $('#user-selector').select2({
                        width: '100%',
                        placeholder: @js(__('budgets.input-user-placeholder')),
                        ajax: {
                            url: @js(route('users.companions')),
                            dataType: 'json',
                            delay: 250,
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(item) {
                                        return {
                                            text: item.name,
                                            id: item.id
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                    });


                }

                initSelectors();
                $('#user-selector').on('select2:select', (e) => $dispatch('selectedUser', {
                    item: e.params.data.id,
                    text: e.params.data.text
                }));
                Livewire.hook('morph.updated', initSelectors);
            })
        </script>
    @endscript
</section>
