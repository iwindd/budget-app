<section class="grid grid-cols-1 gap-2">
    @if ($isOwner)
        <section class="grid grid-cols-9 gap-2">
            <section class="space-y-2 lg:col-span-8 md:col-span-6 col-span-9">
                <x-form.label for="user_id" :value="__('budgets.input-companion')" />
                <form wire:submit="save" id="companion-add-form">
                    <select name="user_id" id="companions-selector" class="w-full">
                        @isset($user_id)
                            @isset($user_label)
                                <option value="{{ $user_id }}" selected>{{ $user_label }}</option>
                            @endisset
                        @endisset
                    </select>
                </form>
                <div>
                    <x-form.error :messages="$errors->get('user_id')" />
                </div>
            </section>
            <section class="space-y-2 lg:col-span-1 md:col-span-3 col-span-9">
                <x-form.label for="submit" :value="__('budgets.table-companion-action')" />
                <x-button type="submit" name="submit" form="companion-add-form"
                    class="w-full text-end truncate"><i>{{ __('budgets.add-companion-btn') }}</i></x-button>
            </section>
        </section>
        <hr>
    @endif
    <section class="relative overflow-x-auto border">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-inherit">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-inherit dark:text-inherit">
                <tr>
                    <th class="px-6 py-3 w-[50%]">{{ __('budgets.table-companion-name') }}</th>
                    <th class="px-6 py-3">{{ __('budgets.table-companion-expense') }}</th>
                    <th class="px-6 py-3 text-end">{{ __('budgets.table-companion-address') }}</th>
                    <th class="px-6 py-3 text-end">{{ __('budgetitems.table-hasData') }}</th>
                    @if ($isOwner)
                        <th class="px-6 py-3 text-end">{{ __('budgets.table-companion-action') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($companions as $user)
                    <tr wire:key="{{ $user['id'] }}">
                        <td class="px-6 py-1">{{ $user['user']['name'] }}</td>
                        <td class="px-6 py-1">{{ count($user['expenses']) }} รายการ</td>
                        <td class="px-6 py-1 text-end">{{ count($user['addresses']) }} รายการ</td>
                        <td class="px-6 py-1 text-end">
                            @if (count($user['expenses']) > 0 && count($user['addresses']) > 0)
                                {!!__('budgetitems.table-hasData-true')!!}
                            @else
                                {!!__('budgetitems.table-hasData-false')!!}
                            @endif
                        </td>
                        @if ($isOwner)
                            <td class="px-6 py-1 text-end">
                                <x-button type="button" wire:click.prevent="removeCompanion({{ $user['id'] }})" icon-only
                                    variant="danger">
                                    <x-heroicon-o-trash class="w-6 h-6" />
                                </x-button>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-1 text-center">{{ __('budgets.table-expenses-not-found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    @script
        <script>
            $(document).ready(function(e) {
                window.initSelectors = () => {
                    $('#companions-selector').select2({
                        width: '100%',
                        placeholder: @js(__('budgets.input-companion-placeholder')),
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
                $('#companions-selector').on('select2:select', (e) => $dispatch('selectedCompanion', {
                    item: e.params.data.id,
                    text: e.params.data.text
                }));
                Livewire.hook('morph.updated', initSelectors);
            })
        </script>
    @endscript
</section>
