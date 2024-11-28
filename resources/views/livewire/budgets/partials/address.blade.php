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
            addressesSelectize: @entangle('addressSelectize'),
            get addressesRaw(){
                const extract = [];
                this.addressesMinimized
                    .sort(this.sort)
                    .forEach(address => {
                        const fromDate = moment(address.from_date);
                        const backDate = moment(address.back_date);

                        if (address.multiple) {
                            this.getDatesBetween(fromDate, backDate).forEach(date => {
                                extract.push({
                                    ...address,
                                    from_date: moment(date).set({
                                        hour: fromDate.hour(),
                                        minute: fromDate.minute(),
                                    }).format('YYYY-MM-DD HH:mm'),
                                    back_date: moment(date).set({
                                        hour: backDate.hour(),
                                        minute: backDate.minute(),
                                    }).format('YYYY-MM-DD HH:mm'),
                                });
                            });
                        } else {
                            extract.push(address);
                        }
                    });

                return extract;
            },
            addressesMinimized: @entangle('addresses'),
            extractIndex: {},
            errorList: {},
            editing: @entangle('addressEditing'),
            calender: null,
            locales: {
                ['table-date-value']: @js(__('address.table-date-value')),
                ['table-date-value:stack']: @js(__('address.table-date-value:stack')),
                ['table-distance-value']: @js(__('address.table-distance-value')),
                ['table-total-value']: @js(__('address.table-total-value')),
                ['table-time-hr-format']: @js(__('address.table-time-hr-format')),
                ['table-time-day-format']: @js(__('address.table-time-day-format')),
            },
            sort(a, b) {
                return moment(a.from_date).isBefore(b.from_date) ? -1 : moment(a.from_date).isAfter(b.from_date) ? 1 : 0;
            },
            timeToPercentage(time) {
                const totalMinutesInDay = 24 * 60;

                const date = moment(time, 'HH:mm');

                const minutesPastMidnight = date.hour() * 60 + date.minute();

                const percentage = (minutesPastMidnight / totalMinutesInDay) * 100;

                return percentage;
            },
            hasEvent(point) {
                point = moment(point);

                return this.addressesRaw.find(a =>
                    point.isBetween(a.from_date, a.back_date, null, '[]')
                )
            },
            getEventsBetween(from, back, bag, noEditing) {
                const pool = (bag || this.addressesRaw);
                const editingItem = this.addressesMinimized[this.editing];
                return pool.filter(a => {
                    if (noEditing && editingItem){
                        if (
                            a.plate     == editingItem.plate     &&
                            a.distance  == editingItem.distance  &&
                            a.from_id   == editingItem.from_id   &&
                            a.back_id   == editingItem.back_id
                        ){
                            if (editingItem.multiple) {
                                const [from, back] = [moment(a.from_date), moment(a.back_date)];
                                const [from2, back2] = [moment(editingItem.from_date), moment(editingItem.back_date)];

                                if (
                                    from.hour() == from2.hour() &&
                                    back.hour() == back2.hour() &&
                                    from.minute() == from2.minute() &&
                                    back.minute() == back2.minute() &&
                                    from.isBetween(from2, back2, undefined, '[]') &&
                                    back.isBetween(from2, back2, undefined, '[]')
                                ){
                                    return false;
                                }
                            }else{
                                if (a.from_date == editingItem.from_date && a.back_date == editingItem.back_date){
                                    return false;
                                }
                            }
                        }
                    }

                    return this.isEventBetween(a, from, back);
                });
            },
            isEventBetween(address, from, back){
                const startDate = moment(from);
                const endDate = moment(back);
                const addressStart = moment(address.from_date);
                const addressEnd = moment(address.back_date);

                return (
                    addressStart.isBetween(startDate, endDate, null, '[]') || // Address starts within the range
                    addressEnd.isBetween(startDate, endDate, null, '[]') ||   // Address ends within the range
                    startDate.isBetween(addressStart, addressEnd, null, '[]') || // Range starts within the address
                    endDate.isBetween(addressStart, addressEnd, null, '[]')   // Range ends within the address
                );
            },
            getEventsIn(date, noEditing){
                const from = moment(date).set({hour: 0, minute: 0});
                const back = from.clone().set({hour: 23, minute: 59});

                return this.getEventsBetween(from, back, undefined, noEditing)
            },
            getDatesBetween(startDate, endDate) {
                startDate = moment(startDate);
                endDate = moment(endDate);

                const now = startDate, dates = [];

                while (now.isBefore(endDate) || now.isSame(endDate)) {
                    dates.push(now.format('Y-MM-DD'));
                    now.add(1, 'days');
                }
                return dates;
            },
            extractAddress(address){
                const output = [];
                const fromDate = moment(address.from_date);
                const backDate = moment(address.back_date);

                if (address.multiple) {
                    this.getDatesBetween(fromDate, backDate).forEach(date => {
                        output.push({
                            ...address,
                            from_date: moment(date).set({
                                hour: fromDate.hour(),
                                minute: fromDate.minute()
                            }).format('YYYY-MM-DD HH:mm'),
                            back_date: moment(date).set({
                                hour: backDate.hour(),
                                minute: backDate.minute()
                            }).format('YYYY-MM-DD HH:mm')
                        });
                    });
                } else {
                    output.push(address);
                }

                return output;
            },
            action(address){
                if (address?.ri == undefined) return;
                const [from, back] = [moment(address.from_date), moment(address.back_Date)];

                if (!from.isSame(back, 'day') && address.multiple ){
                    this.extractIndex = {[address.ri]: true}
                }

                return this.edit(address)
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
                return result.map(group => group.map(date => date.format('Y-MM-DD')));
            },
            cancelEdit(){
                this.editing = null;
                this.extractIndex = {};
                this.dates = [];
            },
            removeEdit(){
                if (this.editing == null) return;
                const payload = this.addressesMinimized;
                console.log(payload, this.editing);
                payload.splice(this.editing, 1);

                this.cancelEdit();
                this.addressesMinimized = payload;
            },
            rawWithoutAddress(ri){
                const target = this.addressesMinimized[ri];
                if (!target) return;

                return this.addressesRaw.filter((a) => {
                    if (
                        target &&
                        a.plate     == target.plate     &&
                        a.distance  == target.distance  &&
                        a.from_id   == target.from_id   &&
                        a.back_id   == target.back_id
                    ) {
                        if (target.multiple) {
                            const [from, back] = [moment(a.from_date), moment(a.back_date)];
                            const [from2, back2] = [moment(target.from_date), moment(target.back_date)];

                            if (
                                from.hour() == from2.hour() &&
                                back.hour() == back2.hour() &&
                                from.minute() == from2.minute() &&
                                back.minute() == back2.minute() &&
                                from.isBetween(from2, back2, undefined, '[]') &&
                                back.isBetween(from2, back2, undefined, '[]')
                            ){
                                return false;
                            }
                        }else{
                            if (a.from_date == target.from_date && a.back_date == target.back_date){
                                return false;
                            }
                        }
                    }

                    return true;
                })
            },
            edit(address) {
                if (this.editing || !this.calender || !address || address?.ri == undefined  || this.editing == address.ri ) return this.cancelEdit();
                const [from, back] = [moment(address.from_date), moment(address.back_date)];

                this.from_location_id = address.from_id;
                this.back_location_id = address.back_id;
                this.from_time = from.format('HH:mm');
                this.back_time = back.format('HH:mm');
                this.plate = address.plate;
                this.distance = address.distance;
                this.editing = address.ri;

                const isMultiple = address.multiple || from.isSame(back, 'day') ? true: false;

                if (isMultiple){
                    this.calender.setDate(this.getDatesBetween(from, back), true);
                }else{
                    this.calender.setDate([from.format('Y-MM-DD'), back.format('Y-MM-DD')], true);
                }

                this.calender.set('mode', isMultiple ? 'multiple' : 'range');
                this.checkbox = isMultiple;
            },
            onError(field, label){
                this.errorList[field] = label;
            },
            validate(){
                this.errorList = {}
                if (this.dates.length <= 0) this.onError('dates', 'วันที่ไม่ถูกต้อง!');
                if (this.errors.length > 0) this.onError('dates', 'มีการเดินทางในช่วงเวลาดังกล่าวอยู่แล้ว!');
                if (!(+this.distance) || (+this.distance <= 0)) this.onError('distance', 'ระยะทางไม่ถูกต้อง!');
                if (!this.plate) this.onError('plate', 'ทะเบียนรถไม่ถูกต้อง!');
                if (!this.from_location_id) this.onError('from_id', 'ไม่พบสถานที่ออกเดินทาง!');
                if (!this.back_location_id) this.onError('back_id', 'ไม่พบสถานที่กลับถึง!');
                if (!this.from_time) this.onError('from_time', 'เวลาออกเดินทางไม่ถูกต้อง!');
                if (!this.back_time) this.onError('back_time', 'เวลากลับถึงไม่ถูกต้อง!');

                return Object.keys(this.errorList).length > 0;
            },
            submit()  {
                const hasError = this.validate();
                if (hasError) return;
                let payload = []
                const pool = this.editing == null ? this.addressesRaw : this.rawWithoutAddress(this.editing);
                const object  = {
                    from_id: this.from_location_id, back_id: this.back_location_id,
                    plate: this.plate, distance: this.distance,
                    from_time: this.from_time, back_time: this.back_time,
                    multiple: this.checkbox, dates: this.dates
                }

                const addEvent = (f, b) => {
                    payload.push({
                        ...object,
                        from_date: f.format('Y-MM-DD HH:mm'),
                        back_date: b.format('Y-MM-DD HH:mm'),
                        multiple: f.isSame(b, 'day') ? true : object.multiple
                    })
                }

                if (object.multiple){
                    this.splitDates(object.dates) .map(dates => dates.map(date=> {
                        const f = moment(date+' '+object.from_time);
                        const b = moment(date+' '+object.back_time);

                        addEvent(f, b)
                    }))
                }else{
                    const f = moment(object.dates[0]+' '+object.from_time);
                    const b = moment(object.dates[1]+' '+object.back_time);

                    addEvent(f, b)
                }

                payload =  Object.values(
                    [...pool, ...payload].reduce((acc, item) => {
                        const key = `${item.from_date}-${item.back_date}`; // Unique identifier
                        if (!acc[key]) {
                            acc[key] = item; // Add to accumulator if not already present
                        }
                        return acc;
                    }, {})
                );

                this.addressesRaw = payload;
                this.addressesMinimized = this.minimizeAddresses(payload);
                this.dates = [];
                this.extractIndex = {};
                this.calender.redraw();
                this.cancelEdit();
            },
            getLocationLabel(locationId){
                return this.addressesSelectize.find(a => a.id == locationId)?.label || '-'
            },
            formatAddressDate(from, back, multiple) {
                if (!from || !back) return;
                let [localeKey, start, end] = ['table-date-value', '', ''];
                const [fromDate, backDate] = [moment(from), moment(back)];
                const isMultiple = !fromDate.isSame(backDate, 'day') && multiple;

                if (isMultiple){
                    const isSameMonth = fromDate.isSame(backDate, 'month');
                    const isSameYear = fromDate.isSame(backDate, 'year');
                    let format = 'Do';
                    localeKey = 'table-date-value:stack';

                    const timeOfFrom = {
                        hour: fromDate.hour(),
                        minute: fromDate.minute()
                    };

                    if (!isSameMonth) format = 'Do MMM';
                    if (!isSameYear) format = 'll';
                    start = fromDate.format(format) + ' - ' + backDate.clone().set(timeOfFrom).format('lll')
                    end = fromDate.format(format) + ' - ' + backDate.format('lll')

                }else{
                    start = fromDate.format('lll')
                    end = backDate.format('lll')
                    minutes = backDate.diff(fromDate, 'minute')
                }

                return this.locales[localeKey]
                    .replace(':start', start)
                    .replace(':end', end);
            },
            formatAddressTimeDiff(from, back, multiple) {
                if (!from || !back) return console.log('not found');
                const [fromDate, backDate] = [moment(from), moment(back)];
                let minutes = 0;

                if (multiple){
                    let days = backDate.diff(fromDate, 'day')+1;
                    minutes = fromDate.clone().set({
                        hour: backDate.hour(),
                        minute: backDate.minute()
                    }).diff(fromDate, 'minute') * days;
                }else{
                    minutes = backDate.diff(fromDate, 'minute')
                }

                const DAY_MINUTES = 24 * 60
                const days = Math.floor(minutes / DAY_MINUTES);
                const hours = (minutes % DAY_MINUTES) / 60;
                let text = '';

                if (days > 0) text += this.locales['table-time-day-format'].replace(':d', days) + ' ';
                if (hours > 0) text += this.locales['table-time-hr-format'].replace(':hr', hours % 1 === 0 ? hours.toFixed(0) : hours.toFixed(1));

                return text;
            },
            formatAddressDistance(address){
                let round = 1;

                if (address.multiple){
                    round *= moment(address.back_date).diff(address.from_date, 'day')+1;
                }

                return this.locales['table-distance-value']
                    .replace(':distance', (address.distance*round).toLocaleString())
                    .replace(':round', round.toLocaleString())
            },
            formatAddressTotal(address){
                let round = 1;

                if (address.multiple){
                    round *= moment(address.back_date).diff(address.from_date, 'day')+1;
                }

                const distance = address.distance * round
                return this.locales['table-total-value']
                    .replace(':total', (distance * 4).toLocaleString())
            },
            get list() {
                const formatting = this.addressesMinimized.map((a, i) => ({...a, ri: i}))
                let data = formatting.filter((a, i) => !this.extractIndex[i] && a.ri != this.editing);
                const preview = [];

                // extract
                formatting.filter((_, i) => this.extractIndex[i]).map((address) => {
                    if (address.multiple){
                        this.extractAddress(address).map((a) => {
                            if (a.ri != this.editing) data.push(a);
                        })
                    }
                })

                // preview
                if (this.dates.length > 0){
                    const obj = {
                        from_id: this.from_location_id,
                        back_id: this.back_location_id,
                        plate: this.plate,
                        distance: this.distance,
                        from_time: this.from_time,
                        back_time: this.back_time,
                        multiple: this.checkbox,
                        dates: this.dates,
                    }

                    const addPreview = (obj) => {
                        const [from, back] = [
                            moment(obj.dates[0] + ' ' + obj.from_time),
                            moment(obj.dates[obj.dates.length-1] + ' ' + obj.back_time)
                        ]

                        let classList = 'bg-success-200/25';

                        if (this.getEventsBetween(from, back).length > 0){
                            const selected = this.dates.find(date => {
                                return moment(obj.from_date).isSame(date, 'day');
                            });

                            classList = selected ? 'bg-warning-200/25' : 'bg-danger-200/25'
                        }

                        preview.push({
                            ...obj,
                            from_date: from.format('Y-MM-DD HH:mm'),
                            back_date: back.format('Y-MM-DD HH:mm'),
                            classList: 'bg-success-200/25'
                        })
                    }

                    if (obj.multiple){
                        console.log(obj.dates);
                        obj.dates.map(date => addPreview({...obj, dates: [date]}))
                    }else{
                        addPreview(obj)
                    }

                    data.map(a => {
                        if (a.editing) {
                            const found = obj.dates.find((date) => {
                                return moment(date).isBetween(a.from_date, a.back_date, null, '[]')
                            })

                            if (found) {
                                return {
                                    ...a,
                                    classList: 'bg-danger-200/25'
                                }
                            }
                        }

                        return a;
                    })
                }

                return [...data, ...preview].sort(this.sort);
            },
            get errors() {
                if (this.dates.length <= 0) return [];
                if (!this.checkbox) {
                    const fromDate = moment(this.dates[0] + ' ' + this.from_time, 'Y-MM-DD HH:mm');
                    const backDate = moment(this.dates[this.dates.length - 1] + ' ' + this.back_time, 'Y-MM-DD HH:mm');

                    return this.getEventsBetween(fromDate, backDate, undefined, true);
                } else {
                    const events = this.dates.flatMap(date => {
                        const fromDate = moment(`${date} ${this.from_time}`, 'Y-MM-DD HH:mm');
                        const backDate = moment(`${date} ${this.back_time}`, 'Y-MM-DD HH:mm');

                        return this.getEventsBetween(fromDate, backDate, undefined, true);
                    });

                    return events;
                }
            }
        }"
        x-init="
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
                    const fromDate = moment(dates[0] + ' ' + from_time, 'Y-MM-DD HH:mm');
                    const backDate = moment(dates[1] + ' ' + back_time, 'Y-MM-DD HH:mm');

                    if (fromDate && backDate && (hasEvent(fromDate) || hasEvent(backDate))) {
                        $inRangePicker.removeClass('event-primary').addClass('event-danger')
                    } else {
                        $inRangePicker.removeClass('event-danger').addClass('event-primary')
                    }
                } else {
                    const isOverlap = dates.find(date => {
                        return hasEvent(moment(date + ' ' + from_time, 'Y-MM-DD HH:mm')) ||
                            hasEvent(moment(date + ' ' + back_time, 'Y-MM-DD HH:mm'))
                    })

                    if (isOverlap) {
                        $inRangePicker.removeClass('event-primary').addClass('event-danger')
                    } else {
                        $inRangePicker.removeClass('event-danger').addClass('event-primary')
                    }
                }

                if (calender) calender.redraw();
            }

            let index = 0;
            calender = flatpickr($refs.datepicker, {
                inline: true,
                mode: checkbox ? 'multiple' : 'range',
                dateFormat: 'Y-MM-DD',
                onChange: (newDates) => {
                    dates = newDates.sort((a, b) => {
                        return moment(a, 'Y-MM-DD').toDate() - moment(b, 'Y-MM-DD').toDate();
                    }).map(date => moment(date).format('Y-MM-DD'));
                    updatePointer()
                },
                formatDate: (date) => moment(date).format('Y-MM-DD'),
                parseDate: (datestr) => moment(datestr, 'Y-MM-DD', true).toDate(),
                disable: [(dateStr)=>{
                    const date = moment(dateStr);
                    const events = getEventsIn(date, true);
                    let minutesLeft = 24 * 60;

                    events.map(e=> {
                        const [from, back] = [moment(e.from_date), moment(e.back_date)];

                        if (from.isSame(back, 'day')) return minutesLeft -= back.diff(from, 'minutes');

                        const [isStart, isEnd] = [date.isSame(from, 'day'), date.isSame(back, 'day')]
                        if (!isStart && !isEnd) minutesLeft = 0;
                        if (isStart) minutesLeft -= from.clone().set({hour: 23,minute: 59}).diff(from, 'minutes');
                        if (isEnd) minutesLeft -= back.diff(back.clone().set({hour: 0,minute: 0}), 'minutes');
                    })

                    return minutesLeft - 1 <= 0;
                }],
                onDayCreate: (dObj, dStr, fp, element) => {
                    const date = moment(element.dateObj);
                    const events = getEventsIn(date, true);

                    events.map(e=> {
                        const [from, back] = [moment(e.from_date), moment(e.back_date)];

                        if (from.isSame(back, 'day')) { // #1: หากเป็นวันเดียวจบ
                            const startAt = timeToPercentage(from);
                            const endAt = timeToPercentage(back)-startAt;
                            return events.push([`event event-primary event-darker-both`, `
                                left: ${startAt}%;
                                width: ${endAt}%;
                            `]);
                        }

                        const [isStart, isEnd] = [date.isSame(from, 'day'), date.isSame(back, 'day')]
                        if (!isStart && !isEnd) {
                            const startAt = timeToPercentage(from);
                            return events.push([`event event-primary`, `width: 100%;`]);
                        }

                        if (isStart) {
                            const startAt = timeToPercentage(from);
                            return events.push([`event event-primary event-darker-start`, `
                                left: ${startAt}%;
                                width: ${100-startAt}%;
                            `]);
                        }

                        if (isEnd) {
                            const endAt = timeToPercentage(back);
                            return events.push([`event event-primary event-darker-end`, `width: ${endAt}%;`]);
                        }
                    })

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
            });

            $watch('dates', (dates) => {
                if (!calender) return;
                const selectedDates = calender.selectedDates.map(date => moment(date).format('Y-MM-DD'));
                const newDates = dates.map(date => moment(date).format('Y-MM-DD'));
                const hasDifference = selectedDates.length !== newDates.length ||
                    selectedDates.some((date, index) => date !== newDates[index]);

                if (hasDifference) {
                    calender.setDate(dates, false);
                }
            });
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

            $watch('addressesMinimized', (data) => {
                dates = [];
                extractIndex = {};
                calender.redraw();
                cancelEdit();
            })
        "

        class="flex flex-col lg:flex-row gap-1"
    >
        @php
            $addressError = array_merge(
                $errors->get('budgetAddressForm.dates', []),
                $errors->get('budgetAddressForm.dates.*', []),
                $errors->get('addresses', []),
                $errors->get('addresses.*', []),
            );
        @endphp
        @if ($hasPermissionToManage)
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

                        <span class="text-sm text-danger-600 dark:text-danger-400 space-y-1" x-text="errorList['dates']"></span>

                        <ul class='text-sm space-y-1 '>
                            <template x-if="errors.length > 0">
                                <li>{{ __('address.busy-table') }}</li>
                            </template>
                            <template x-for="address in errors">
                                <li class="space-x-1 "
                                    x-html='(locales["table-date-value"]
                                    .replace(":start", moment(address.from_date).format("lll"))
                                    .replace(":end", moment(address.back_date).format("lll"))
                                )'>
                                </li>
                            </template>
                        </ul>
                    </section>
                </main>

                <x-checkbox :label="__('address.multiple_dates')" wire:model="budgetAddressForm.multiple" />
            </section>
        @endif
        <section class="flex-grow col-span-4">
            @php
                $root = ['class' => 'col-span-2 lg:col-span-1'];
            @endphp
            @if ($hasPermissionToManage)
                <form wire:submit="onAddAddress" class="grid grid-cols-4 lg:grid-cols-7 gap-1 pb-1 mb-2 border-b">
                    <section>
                        <x-selectize
                            :root="$root"
                            :options="$addressSelectize"
                            lang='address.input-from'
                            wire:model="budgetAddressForm.from_id"
                            :selectOnClose="true"
                        />
                        <span class="text-sm text-danger-600 dark:text-danger-400 space-y-1" x-text="errorList['from_id']"></span>
                    </section>
                    <section>
                        <x-budgets.timepicker :root="$root" lang="address.input-from-datetime"
                        wire:model="budgetAddressForm.from_time" />
                        <span class="text-sm text-danger-600 dark:text-danger-400 space-y-1" x-text="errorList['from_time']"></span>
                    </section>
                    <section>
                        <x-selectize
                            :root="$root"
                            :options="$addressSelectize"
                            lang='address.input-back'
                            wire:model="budgetAddressForm.back_id"
                            :selectOnClose="true"
                        />
                        <span class="text-sm text-danger-600 dark:text-danger-400 space-y-1" x-text="errorList['back_id']"></span>
                    </section>
                    <section>
                        <x-budgets.timepicker :root="$root" lang="address.input-back-datetime"
                        wire:model="budgetAddressForm.back_time" />
                        <span class="text-sm text-danger-600 dark:text-danger-400 space-y-1" x-text="errorList['back_time']"></span>
                    </section>
                    <section>
                        <x-textfield :root="$root" lang="address.input-plate" wire:model="budgetAddressForm.plate" />
                        <span class="text-sm text-danger-600 dark:text-danger-400 space-y-1" x-text="errorList['plate']"></span>
                    </section>
                    <section>
                        <x-textfield :root="$root" lang="address.input-distance"
                        wire:model="budgetAddressForm.distance" />
                        <span class="text-sm text-danger-600 dark:text-danger-400 space-y-1" x-text="errorList['distance']"></span>
                    </section>

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
            @endif

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
                                <th class="px-6 py-3 w-[10%] text-end">{{ __('address.table-distance') }}</th>
                                <th class="px-6 py-3 w-[10%] text-end">{{ __('address.table-total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(address, index) in list" :key="index">
                                <tr
                                    @if ($hasPermissionToManage)
                                        class="cursor-pointer"
                                        x-on:click="action(address)"
                                        :class="address?.classList || 'hover:bg-primary-200/25'"
                                    @endif
                                >

                                    <td class="px-6 py-2" x-text="address.plate"></td>
                                    <td class="px-6 py-2 text-end" x-text="getLocationLabel(address.from_id)"></td>

                                    <td class="px-6 py-2 flex justify-center items-center">
                                        <div class="flex justify-between h-full w-full" x-html="formatAddressDate(address.from_date, address.back_date, address.multiple)"></div>
                                    </td>

                                    <td class="px-6 py-2 text-center" x-text="getLocationLabel(address.back_id)"></td>
                                    <td class="text-end" x-text="formatAddressTimeDiff(address.from_date, address.back_date, address.multiple)"></td>
                                    <td class="text-end" x-text="formatAddressDistance(address)">
                                    <td class="text-end" x-text="formatAddressTotal(address)">
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </section>
            </section>
    </div>
</section>
