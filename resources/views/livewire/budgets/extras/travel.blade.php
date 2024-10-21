<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800" x-data="{
    rows: @entangle('budgetItemTravelForm.rows'),
    template: JSON.stringify({
        plate: '',
        start: null,
        driver: '',
        location: '',
        end: null,
        distance: '',
        round: '',
    })
}" {{-- ทำ template เป็น json เพื่อไป parse เพื่อใช้ deepcopy ป้องกันการแก้ไข --}}>
    <header>
        <h3 class="font-bold">{{ __('travel.header') }}</h3>
    </header>
    @if ($budgetItemForm->exists())
        <form wire:submit="onSaveTravel" class="max-w-full">
            <section class="grid grid-cols-4 gap-2">
                <section class="space-y-2 md:col-span-1 col-span-2">
                    <x-form.label :value="__('travel.input-owner')" />
                    <x-form.input disabled type="text" class="block w-full" value="{{ $budgetItemForm->name }}" />
                </section>
                <section class="space-y-2 md:col-span-1 col-span-2">
                    <x-form.label for="budgetItemTravelForm.start" :value="__('travel.input-start')" />
                    <x-form.input id="budgetItemTravelForm.start" name="budgetItemTravelForm.start"
                        wire:model="budgetItemTravelForm.start" type="date" class="block w-full" />
                    <x-form.error :messages="$errors->get('budgetItemTravelForm.start')" />
                </section>
                <section class="space-y-2 md:col-span-1 col-span-2">
                    <x-form.label for="budgetItemTravelForm.end" :value="__('travel.input-end')" />
                    <x-form.input id="budgetItemTravelForm.end" name="budgetItemTravelForm.end"
                        wire:model="budgetItemTravelForm.end" type="date" class="block w-full" />
                    <x-form.error :messages="$errors->get('budgetItemTravelForm.end')" />
                </section>
                <section class="space-y-2 md:col-span-1 col-span-2">
                    <x-form.label for="budgetItemTravelForm.n" :value="__('travel.input-n')" />
                    <x-form.input id="budgetItemTravelForm.n" name="budgetItemTravelForm.n"
                        wire:model="budgetItemTravelForm.n" type="text" class="block w-full" />
                    <x-form.error :messages="$errors->get('budgetItemTravelForm.n')" />
                </section>
            </section>
            <section class="relative overflow-x-auto border-none mt-2">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-inherit border-none">
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-900/10 dark:text-inherit text-center">
                        <tr class="border">
                            <th class="pb-3 border" rowspan="2">{{ __('exports.travel-table-order') }}</th>
                            <th class="w-[12.5%] border" rowspan="2">{{ __('exports.travel-table-plate') }}</th>
                            <th class="w-[12.5%] border" colspan="2">{{ __('exports.travel-table-travel') }}</th>
                            <th class="w-[12.5%] border" rowspan="2">{{ __('exports.travel-table-vehicle-user') }}
                            </th>
                            <th class="w-[12.5%] border" rowspan="2">{{ __('exports.travel-table-place') }}</th>
                            <th class="w-[12.5%] border" colspan="2">{{ __('exports.travel-table-back') }}</th>
                            <th class="border" rowspan="2">{!! __('exports.travel-table-distance') !!}</th>
                            <th class="border" rowspan="2">{{ __('exports.travel-table-round') }}</th>
                            <th class="border" rowspan="2">{{ __('exports.travel-table-total-distance') }}</th>
                            <th class="border" rowspan="2">{!! __('exports.travel-table-bahtperkm') !!}</th>
                            <th class="border" rowspan="2">{!! __('exports.travel-table-action') !!}</th>
                        </tr>
                        <tr class="border">
                            <th class="pt-2">{{ __('exports.travel-table-date') }}</th>
                            <th>{{ __('exports.travel-table-time') }}</th>
                            <th>{{ __('exports.travel-table-date') }}</th>
                            <th>{{ __('exports.travel-table-time') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(row, index) in rows">
                            <tr class="travel-row">
                                <td class="bg-gray-50 dark:bg-gray-900-10 text-center border"><i x-text="index+1"></i>
                                </td>
                                <td>
                                    <input type="text" x-model="rows[index].plate"
                                        placeholder="{{ __('travel.row-input-plate') }}" autofocus>
                                </td>
                                <td colspan="2">
                                    <input type="datetime-local" x-model="rows[index].start" name="start" id="start">
                                </td>
                                <td>
                                    <input type="text" x-model="rows[index].driver" name="driver"
                                        id="driver"placeholder="{{ __('travel.row-input-driver') }}">
                                </td>
                                <td>
                                    <input type="text" x-model="rows[index].location" name="location" id="location"
                                        placeholder="{{ __('travel.row-input-location') }}">
                                </td>
                                <td colspan="2">
                                    <input type="datetime-local" x-model="rows[index].end" name="end" id="end">
                                </td>
                                <td>
                                    <input type="number" x-model="rows[index].distance" name="distance" id="distance"
                                        placeholder="{{ __('travel.row-input-distance') }}">
                                </td>
                                <td>
                                    <input type="number" x-model="rows[index].round" name="round" id="round"
                                        placeholder="{{ __('travel.row-input-round') }}">
                                </td>
                                <td class="bg-gray-50 dark:bg-gray-900/10 text-center border">
                                    <span x-text="(rows[index].distance * rows[index].round).toFixed(1)"></span>
                                </td>
                                <td class="bg-gray-50 dark:bg-gray-900/10 text-center border">
                                    <span x-text="((rows[index].distance * rows[index].round) * 4).toFixed(0) "></span>
                                </td>
                                <td class="bg-gray-50 dark:bg-gray-900/10 text-center border">
                                    <div class="w-full h-full flex justify-center">
                                        <x-button x-on:click="rows.splice(index, 1)" type="button" icon-only
                                            variant="danger" size="sm">
                                            <x-heroicon-o-trash class="w-6 h-6" />
                                        </x-button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <tr>
                            <td x-on:click="rows.push(JSON.parse(template))" colspan="13"
                                class="py-2 text-center bg-gray-50 dark:bg-gray-900-10 hover:bg-gray-100 text-center border cursor-pointer">
                                <span class="select-none">{{__("travel.add-btn")}}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                @if ($errors->has('budgetItemTravelForm.rows.*'))
                    <span
                        class="text-sm text-red-600 dark:text-red-400 space-y-1">{{ __('travel.rows-error') }}</span>
                    {{-- TODO:: REWORK LATER. SO TRIED --}}
                    @foreach ($errors->get('budgetItemTravelForm.rows.*') as $error)
                        <x-form.error :messages="$error" />
                    @endforeach
                @endif
            </section>
            <div class="max-w-full mt-2">
                <section class="max-w-full col-span-2 flex justify-end">
                    <x-button type="submit" variant="success">{{__('travel.save-btn')}}</x-button>
                </section>
            </div>
        </form>
    @else
        <x-form.error class="indent-4" :messages="__('travel.budget-item-not-found')" />
    @endif
</div>
