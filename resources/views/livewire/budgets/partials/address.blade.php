<section class="max-w-full">
    <div
        x-data="{
            {{-- INPUT --}}
            from_location_id: @entangle('budgetAddressForm.from_id'),
            back_location_id: @entangle('budgetAddressForm.back_id'),
            dates: @entangle('budgetAddressForm.dates'),
            from_time: @entangle('budgetAddressForm.from_time'),
            back_time: @entangle('budgetAddressForm.back_time'),
            plate: @entangle('budgetAddressForm.plate'),
            distance: @entangle('budgetAddressForm.distance'),
            checkbox: @entangle('budgetAddressForm.multiple'),
            {{--  --}}
            addressesRaw: @entangle('addresses'),
            addressesSelectize: @entangle('addressSelectize'),
            editing: null,
            calender: null,
            locales: {
                ['table-date-value']: @js(__('address.table-date-value')),
                ['table-date-value:stack']: @js(__('address.table-date-value:stack')),
                ['table-distance-value']: @js(__('address.table-distance-value')),
                ['table-time-hr-format']: @js(__('address.table-time-hr-format')),
                ['table-time-day-format']: @js(__('address.table-time-day-format')),
            },
            sort(a, b) {
                return a.fromDate.isBefore(b.fromDate) ? -1 : a.fromDate.isAfter(b.fromDate) ? 1 : 0;
            },
            timeToPercentage(time) {
                const totalMinutesInDay = 24 * 60;

                const date = moment(time, 'HH:mm');

                const minutesPastMidnight = date.hour() * 60 + date.minute();

                const percentage = (minutesPastMidnight / totalMinutesInDay) * 100;

                return percentage;
            },
            hasEvent(pointDate) {
                return this.addresses.find((address) => moment(pointDate).isBetween(address.fromDate, address.backDate, null, '[]'))
            },
            getEventsBetween(start, end) {
                start = moment(start);
                end = moment(end);

                return this.addresses.filter((a) =>
                    (a.fromDate.isBetween(start, end, null, '[]') || a.backDate.isBetween(start, end, null, '[]')) && a.index != this.editing
                )
            },
            getDatesBetween(startDate, endDate) {
                startDate = moment(startDate);
                endDate = moment(endDate);

                const now = startDate, dates = [];

                while (now.isBefore(endDate) || now.isSame(endDate)) {
                    dates.push(now.format('Y-M-D'));
                    now.add(1, 'days');
                }
                return dates;
            },
            splitDates(dates) {
                const momentDates = dates.map(date => moment(date));
                momentDates.sort((a, b) => a - b);

                const result = [];
                let tempGroup = [momentDates[0]];

                for (let i = 1; i < momentDates.length; i++) {
                    if (momentDates[i].diff(momentDates[i - 1], 'days') === 1) {
                        tempGroup.push(momentDates[i]);
                    } else {
                        result.push(tempGroup);
                        tempGroup = [momentDates[i]];
                    }
                }

                if (tempGroup.length) result.push(tempGroup);
                return result.map(group => group.map(date => date.format('Y-M-D')));
            },
            cancelEdit() {
                this.editing = null;
                this.calender.setDate([], true);
            },
            edit(index) {
                const address = this.addresses[index];
                if (this.editing) this.cancelEdit();
                if (!this.calender) return;
                if (!address) return;
                if (this.editing == index) return this.cancelEdit();

                this.from_location_id = address.from_id;
                this.back_location_id = address.back_id;
                this.from_time = address.fromDate.format('HH:mm');
                this.back_time = address.backDate.format('HH:mm');
                this.plate = address.plate;
                this.distance = address.distance;
                this.editing = index;

                if (address.multiple){
                    this.calender.setDate(this.getDatesBetween(address.fromDate, address.backDate), true);
                }else{
                    this.calender.setDate([address.fromDate.format('Y-M-D'), address.backDate.format('Y-M-D')], true);
                }

                this.calender.set('mode', address.multiple ? 'multiple' : 'range');
                this.checkbox = address.multiple;
            },
            submit() {
                if (this.editing != null)
                    this.addressesRaw = this.addressesRaw.filter((_, i) => i != this.editing);
                    // remove old item before add

                $wire.onAddAddress();
            },
            removeEdit(){
                if (this.editing == null) return;

                this.addressesRaw = this.addressesRaw.filter((_, i) => i != this.editing);
                this.cancelEdit();
            },
            get newItems() {
                if (this.dates.length <= 0) return [];
                const payload = [];
                const from_date = `${this.dates[0]} ${this.from_time}`;
                const back_date = `${this.dates[this.dates.length - 1]} ${this.back_time}`;

                const _editItem = (this.editing != null ? (this.addresses[this.editing] || {}) : {});
                const inputData = {
                    ..._editItem,
                    multiple: this.checkbox,
                    plate: this.plate,
                    distance: this.distance,
                    from_id: this.from_location_id,
                    back_id: this.back_location_id,
                    from_date: from_date,
                    back_date: back_date,
                    isNew: this.editing == null,
                    index: -1
                };

                if (inputData.multiple) {
                    this.splitDates(this.dates).map(stack => {
                        const from_date = `${stack[0]} ${this.from_time}`;
                        const back_date = `${stack[stack.length-1]} ${this.back_time}`;

                        payload.push({
                            ...inputData,
                            from_date: from_date,
                            back_date: back_date,
                        })
                    })
                } else {
                    payload.push(inputData);
                }

                return payload.map(a => ({
                    ...a,
                    fromDate: moment(a.from_date),
                    backDate: moment(a.back_date),
                }));
            },
            get list() {
                const formatAddressDate = (address) => {
                    let localeKey = 'table-date-value';
                    let start = '';
                    let end = '';

                    if (address.multiple && address.backDate.diff(address.fromDate, 'day') > 0) {
                        const lastDayInStack = address.backDate;
                        const isSameMonth = address.fromDate.isSame(lastDayInStack, 'month');
                        const isSameYear = address.fromDate.isSame(lastDayInStack, 'year');
                        let format = 'Do';
                        localeKey = 'table-date-value:stack';

                        lastDayInStack.set({
                            hour: address.fromDate.hour(),
                            minute: address.fromDate.minute()
                        })

                        if (!isSameMonth) format = 'Do MMM';
                        if (!isSameYear) format = 'll';
                        start = address.fromDate.format(format) + ' - ' + lastDayInStack.format('lll')
                        end = address.fromDate.format(format) + ' - ' + lastDayInStack.format('lll')
                    } else {
                        start = address.fromDate.format('lll')
                        end = address.backDate.format('lll')
                    }

                    return this.locales[localeKey]
                        .replace(':start', start)
                        .replace(':end', end);
                }

                const formatAddressTimeDiff = (address) => {
                    const DAY_MINUTES = 24 * 60
                    const days = Math.floor(address.minutes / DAY_MINUTES);
                    const hours = (address.minutes % DAY_MINUTES) / 60;
                    let text = '';

                    if (days > 0) text += this.locales['table-time-day-format'].replace(':d', days) + ' ';
                    if (hours > 0) text += this.locales['table-time-hr-format'].replace(':hr', hours % 1 === 0 ? hours.toFixed(0) : hours.toFixed(1));

                    return text;
                }

                const data = [...this.addresses.filter(a => a.index != this.editing), ...this.newItems];

                return data.sort(this.sort).map((address, index) => ({
                    ...address,
                    date: formatAddressDate(address),
                    timeDiff: formatAddressTimeDiff(address),
                    distanceResult: 0,
                    from: this.addressesSelectize.find(a => a.id == address.from_id)?.label,
                    back: this.addressesSelectize.find(a => a.id == address.back_id)?.label,
                    index: address.index
                }));
            },
            get addresses() {
                const payload = this.addressesRaw.map((address, index) => ({
                    ...address,
                    index: index,
                    fromDate: moment(address.from_date),
                    backDate: moment(address.back_date)
                }))

                payload.sort(this.sort);
                return payload.map((a, index) => ({
                    ...a,
                    minutes: a.multiple ?
                        (a.backDate.diff(a.backDate.clone().set({
                            hour: a.fromDate.hour(),
                            minute: a.fromDate.minute()
                        }), 'minutes') * (a.backDate.diff(a.fromDate, 'days') + 1)) : (a.backDate.diff(a.fromDate, 'minutes'))
                }))
            },
            get errors() {
                if (this.dates.length <= 0) return [];
                if (!this.checkbox) {
                    const fromDate = moment(this.dates[0] + ' ' + this.from_time, 'Y-M-D HH:mm');
                    const backDate = moment(this.dates[this.dates.length - 1] + ' ' + this.back_time, 'Y-M-D HH:mm');

                    return this.getEventsBetween(fromDate, backDate);
                } else {
                    const events = this.dates.flatMap(date => {
                        const fromDate = moment(`${date} ${this.from_time}`, 'Y-M-D HH:mm');
                        const backDate = moment(`${date} ${this.back_time}`, 'Y-M-D HH:mm');

                        return this.getEventsBetween(fromDate, backDate);
                    });

                    return events;
                }
            },
        }"
        x-init="
            const shouldDisable = (targetDate, useEvents, noDisablePointEvent = true) => {
                const events = [];
                targetDate = moment(new Date(targetDate));
                const dayEvents = addresses.filter(a => targetDate.isBetween(a.fromDate, a.backDate, 'day', '[]'))

                let inRange = false;
                let pointEvent = false;
                let minuteLeft = 24 * 60;

                if (dayEvents.length > 0) {
                    dayEvents.map(event => {
                        if (event.multiple) {
                            const fromDate = targetDate.clone().set({
                                hour: event.fromDate.hour(),
                                minute: event.fromDate.minute()
                            });

                            const backDate = targetDate.clone().set({
                                hour: event.backDate.hour(),
                                minute: event.backDate.minute()
                            })

                            minuteLeft -= (backDate.diff(fromDate, 'minute'));
                        } else {
                            const isPointEvent = targetDate.isSame(event.fromDate, 'day') || targetDate.isSame(event.backDate, 'day')
                            if (isPointEvent) pointEvent = isPointEvent;

                            if (targetDate.isBetween(event.fromDate, event.backDate, null, '()') && !isPointEvent) {
                                inRange = event;
                                minuteLeft = 0;
                            } else {
                                const backDate = event.backDate.clone();
                                if (!backDate.isSame(event.fromDate, 'day')) {
                                    backDate.set({
                                        'year': event.fromDate.year(),
                                        'month': event.fromDate.month(),
                                        'date': event.fromDate.date(),
                                        'hour': 23,
                                        'minute': 59
                                    });
                                }

                                minuteLeft -= backDate.diff(event.fromDate, 'minutes')
                            }
                        }
                    })
                }

                const noMoreSpace = minuteLeft - 1 <= 0;
                const isEditing = inRange && inRange.index == editing
                const result = isEditing ? false : (noDisablePointEvent ? noMoreSpace : pointEvent ? false : noMoreSpace);

                if (inRange) events.push([`event ${isEditing ? 'event-warning': 'event-primary'} event-decoration w-full`]);
                if (useEvents) return [result, events];
                return result;
            }

            const updatePointer = () => {
                const percentageFrom = timeToPercentage(from_time);
                const percentageBack = timeToPercentage(back_time)

                document.documentElement.style.setProperty('--startRange-Left', `${percentageFrom}%`);
                document.documentElement.style.setProperty('--startRange-Width', `${100 - percentageFrom}%`);

                document.documentElement.style.setProperty('--endRange-Left', `0%`);
                document.documentElement.style.setProperty('--endRange-Width', `${percentageBack}%`);

                document.documentElement.style.setProperty('--fullRange-Left', `${percentageFrom}%`);
                document.documentElement.style.setProperty('--fullRange-Width', `${percentageBack - percentageFrom}%`);

                const $inRangePicker = $(`.datepicker-address .flatpickr-day.selected .event.event-pointer, .datepicker-address .flatpickr-day.inRange .event.event-pointer`)
                if (!checkbox) {
                    const fromDate = moment(dates[0] + ' ' + from_time, 'Y-M-D HH:mm');
                    const backDate = moment(dates[1] + ' ' + back_time, 'Y-M-D HH:mm');

                    if (fromDate && backDate && (hasEvent(fromDate) || hasEvent(backDate))) {
                        $inRangePicker.removeClass('event-primary').addClass('event-danger')
                    } else {
                        $inRangePicker.removeClass('event-danger').addClass('event-primary')
                    }
                } else {
                    const isOverlap = dates.find(date => {
                        return hasEvent(moment(date + ' ' + from_time, 'Y-M-D HH:mm')) ||
                            hasEvent(moment(date + ' ' + back_time, 'Y-M-D HH:mm'))
                    })

                    if (isOverlap) {
                        $inRangePicker.removeClass('event-primary').addClass('event-danger')
                    } else {
                        $inRangePicker.removeClass('event-danger').addClass('event-primary')
                    }
                }

                if (calender) calender.redraw();
            }

            const createEvents = (element, elementDate) => {
                const targetDate = moment(elementDate);
                const events = [];
                let hoverStartPercentage = 50;
                let hoverEndPercentage = 50;
                let disabledHover = false;

                const [isDisabled, hasEvents] = shouldDisable(targetDate, true, false)
                hasEvents.map(event => events.push(event))
                if (isDisabled) {
                    disabledHover = true;
                } else {
                    addresses.map(address => {
                        const isEditing = address.index == editing;
                        const buffers = !address.multiple ? [address] :
                            getDatesBetween(address.fromDate, address.backDate).map(date => ({
                                ...address,
                                fromDate: moment(date).set({
                                    'hour': address.fromDate.hour(),
                                    'minute': address.fromDate.minute()
                                }),
                                backDate: moment(date).set({
                                    'hour': address.backDate.hour(),
                                    'minute': address.backDate.minute()
                                }),
                            }));

                        buffers.map((b) => {
                            const fromDate = b.fromDate;
                            const backDate = b.backDate;

                            const isStartDate = fromDate.isSame(targetDate, 'day');
                            const isEndDate = backDate.isSame(targetDate, 'day');
                            const isOneDay = isStartDate && isEndDate;

                            if (isOneDay) {
                                const percentageStart = timeToPercentage(fromDate)
                                const percentageEnd = timeToPercentage(backDate)
                                events.push([`event ${isEditing ? 'event-warning' : 'event-primary'} event-darker-both`, `
                                                        left: ${percentageStart}%;
                                                        width: ${percentageEnd-percentageStart}%;
                                                    `])
                            } else {
                                if (isStartDate) {
                                    const percentage = timeToPercentage(fromDate)
                                    events.push([`event ${isEditing ? 'event-warning' : 'event-primary'} event-darker-start`, `
                                                            left: ${percentage.toFixed(0)}%;
                                                            width: ${100-percentage.toFixed(0)}%;
                                                        `]);
                                }

                                if (isEndDate) {
                                    const percentage = timeToPercentage(backDate)
                                    events.push([`event ${isEditing ? 'event-warning' : 'event-primary'} event-darker-end`, `
                                                            width: ${percentage}%;
                                                        `]);
                                }
                            }
                        })



                    })
                }

                element.innerHTML += `
                                        <div class='events'>
                                            ${
                                                events.map((event) => {
                                                        return `<span class='${event[0]} event-standard' style='${event[1]}'></span>`;
                                                }).join('') // join the array to convert it into a single string
                                            }

                                            <span class='event event-success event-pointer '></span>
                                        </div>
                                    `;
            }

            let index = 0;
            calender = flatpickr($refs.datepicker, {
                inline: true,
                mode: checkbox ? 'multiple' : 'range',
                dateFormat: 'Y-M-D',
                onChange: (newDates) => {
                    dates = newDates.sort((a, b) => {
                        return moment(a, 'Y-M-D').toDate() - moment(b, 'Y-M-D').toDate();
                    }).map(date => moment(date).format('Y-M-D'));
                    updatePointer()
                },
                formatDate: (date) => moment(date).format('Y-M-D'),
                parseDate: (datestr) => moment(datestr, 'Y-M-D', true).toDate(),
                disable: [shouldDisable],
                onDayCreate: (dObj, dStr, fp, dayElem) => createEvents(dayElem, dayElem.dateObj)
            });

            $watch('dates', (dates) => {
                if (!calender) return;
                const selectedDates = calender.selectedDates.map(date => moment(date).format('Y-M-D'));
                const newDates = dates.map(date => moment(date).format('Y-M-D'));
                const hasDifference = selectedDates.length !== newDates.length ||
                    selectedDates.some((date, index) => date !== newDates[index]);

                if (hasDifference) {
                    cancelEdit();
                    calender.setDate(dates, false);
                }
            });
            $watch('addressesRaw', updatePointer);
            $watch('from_time', updatePointer);
            $watch('back_time', updatePointer);
            $watch('checkbox', (isMultiple) => {
                if (isMultiple && calender?.config?.mode == 'multiple') return;
                if (isMultiple) {
                    // old is range to multiple
                    const startDate = dates[0];
                    const endDate = dates[1];

                    if (startDate && endDate) {
                        calender.setDate(getDatesBetween(startDate, endDate), true)
                    } else {
                        calender.setDate([startDate], true);
                    }
                } else {
                    // old is multiple to range
                    if (dates.length >= 2) {
                        const startDate = dates[0];
                        const endDate = dates[dates.length - 1];

                        calender.setDate([startDate, endDate], true)
                    } else {
                        calender.setDate(dates, true);
                    }
                }
                calender.set('mode', isMultiple ? 'multiple' : 'range')
            })
        "

        class="flex flex-col lg:flex-row gap-1"
    >
        @php
            $addressError = array_merge(
                $errors->get('budgetAddressForm.dates', []),
                $errors->get('budgetAddressForm.dates.*', []),
            );
        @endphp
        <section class="w-[310]">
            <label
                class="block font-medium text-sm {{ count($addressError) > 0 ? 'text-danger' : 'text-gray-700 dark:text-gray-300 ' }}">
                {{ __('address.input-range') }}
            </label>
            <main class="flex flex-row lg:flex-col datepicker-address gap-1 pb-2">
                <section class="w-[310]" wire:ignore>
                    <textfield id="budgetAddressForm.dates" type="hidden" x-ref="datepicker" class="hidden">
                </section>
                <section>
                    @foreach ($addressError as $error)
                        <x-form.error :messages="$error" />
                    @endforeach

                    <ul class='text-sm space-y-1 '>
                        <template x-if="errors.length > 0">
                            <li>{{ __('address.busy-table') }}</li>
                        </template>
                        <template x-for="address in errors">
                            <li class="space-x-1 "
                                x-html='(locales["table-date-value"]
                                .replace(":start", address.fromDate.format("lll"))
                                .replace(":end", address.backDate.format("lll"))
                            )'>
                            </li>
                        </template>
                    </ul>
                </section>
            </main>

            <x-checkbox :label="__('address.multiple_dates')" wire:model="budgetAddressForm.multiple" />
        </section>
        <section class="flex-grow col-span-4">
            @php
                $root = ['class' => 'col-span-2 lg:col-span-1'];
            @endphp
            <form x-on:submit.prevent="submit" class="grid grid-cols-4 lg:grid-cols-7 gap-1 pb-1 mb-2 border-b">
                <x-selectize :root="$root" :options="$addressSelectize" lang='address.input-from'
                    wire:model="budgetAddressForm.from_id" />
                <x-budgets.timepicker :root="$root" lang="address.input-from-datetime"
                    wire:model="budgetAddressForm.from_time" />
                <x-selectize :root="$root" :options="$addressSelectize" lang='address.input-back'
                    wire:model="budgetAddressForm.back_id" />
                <x-budgets.timepicker :root="$root" lang="address.input-back-datetime"
                    wire:model="budgetAddressForm.back_time" />
                <x-textfield :root="$root" lang="address.input-plate" wire:model="budgetAddressForm.plate" />
                <x-textfield :root="$root" lang="address.input-distance"
                    wire:model="budgetAddressForm.distance" />
                <div class="col-span-4 lg:col-span-1">
                    <x-form.label for="submit" :value="__('address.table-action')" />
                    <x-button type="submit" name="submit"
                        class="w-full justify-center truncate">{{ __('address.add-btn') }}</x-button>
                </div>
                <div class="col-span-4 lg:col-span-1 lg:order-last grid grid-cols-2 gap-1">
                    <template x-if="editing != null">
                        <x-button x-on:click="removeEdit()" type="button" name="button" variant="danger" class="w-full justify-center truncate">{{ __('address.remove-btn') }}</x-button>
                    </template>
                    <template x-if="editing != null">
                        <x-button x-on:click="cancelEdit()" type="button" name="button" variant="secondary" class="w-full justify-center truncate">{{ __('address.cancel-btn') }}</x-button>
                    </template>
                </div>
                <div class="col-span-4 lg:col-span-6">
                    <template x-if="editing != null">
                        <span class="text-xs text-danger">หากต้องการแก้ไขข้อมูลการเดินทางบางวันให้ลบวันที่ต้องการแก้ไขและเพิ่มใหม่อีกครั้ง!</span>
                    </template>
                </div>


            </form>
            <section>
                <section class="relative overflow-x-auto border-none mt-2">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-inherit border-none">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-900/10 dark:text-inherit ">
                            <tr>
                                <th class="px-6 py-3 text-start">{{ __('address.table-plate') }}</th>
                                <th class="px-6 py-3 w-[10%] text-end">{{ __('address.table-from-label') }}</th>
                                <th class="px-6 py-3 flex-grow flex justify-between">{!! __('address.table-date') !!}</th>
                                <th class="px-6 py-3 w-[10%] text-center">{{ __('address.table-back-label') }}</th>
                                <th class="px-6 py-3 w-[10%] text-end">{{ __('address.table-time') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="address in list">
                                <tr :class="{
                                    '!bg-warning-100': address && address.index == -1 && !address.isNew,
                                    '!bg-success-100': address && address.index == -1 && address.isNew,
                                    'hover:bg-primary-50': address && !address.isNew,
                                }"
                                    class="transition cursor-pointer" x-on:click="edit(address.index)">
                                    <td class="px-6 py-2" x-html="address.plate"></td>
                                    <td class="px-6 py-2 text-end" x-text="address.from" class="text-l"></td>
                                    <td class="px-6 py-2 flex justify-center items-center">
                                        <div class="flex justify-between h-full w-full" x-html="address.date"></div>
                                    </td>
                                    <td class="px-6 py-2 text-center" x-text="address.back"></td>
                                    <td class="text-end" x-text="address.timeDiff"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </section>
            </section>
    </div>
</section>
