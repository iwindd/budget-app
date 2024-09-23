<section class="space-y-2">
    <header>
        <h3 class="font-bold">{{ __('budgets.budgets-header') }}</h3>
    </header>
    <form action="{{ route('budgets.upsert', ['budget' => $serial]) }}" method="POST" id="budget-form">
        @csrf
        <section class="grid grid-cols-2 gap-2">
            <section class="space-y-2">
                <x-form.label for="serial" :value="__('budgets.input-serial')" />

                <x-form.input id="serial" value="{{ $serial }}" disabled name="serial" type="text"
                    class="block w-full" />

                <x-form.error :messages="$errors->upsertBudget->get('serial')" />
            </section>
            <section class="space-y-2">
                <x-form.label for="date" :value="__('budgets.input-date')" />

                <x-form.input id="date" name="date" type="date" :value="old('date', $data->date ?? '')" class="block w-full"
                    autocomplete="new-date" />

                <x-form.error :messages="$errors->upsertBudget->get('date')" />
            </section>
            <section class="space-y-2">
                <x-form.label :value="__('budgets.input-name')" />

                <x-form.input id="name" value="{{ Auth::user()->name }}" disabled type="text"
                    class="block w-full" />
            </section>
            <section class="space-y-2">
                <x-form.label for="value" :value="__('budgets.input-value')" />

                <x-form.input id="value" name="value" type="number" :value="old('value', $data->value ?? '')" class="block w-full"
                    :placeholder="__('budgets.input-value-placeholder')" autocomplete="new-value" />

                <x-form.error :messages="$errors->upsertBudget->get('value')" />
            </section>
            <hr class="col-span-2 my-3">
            <section class="space-y-2">
                <x-form.label for="header" :value="__('budgets.input-header')" />

                <x-form.input id="header" value="{{__('budgets.input-subject')}}" disabled name="header"
                    type="text" class="block w-full" />
            </section>
            <section class="space-y-2">
                <x-form.label for="office" :value="__('budgets.input-office')" />

                <x-form.input id="office" :value="$office" disabled name="office" type="text"
                    class="block w-full" />
            </section>
            <section class="space-y-2">
                <x-form.label for="invitation" :value="__('budgets.input-invitation')" />

                <x-form.input id="invitation" :value="$invitation" disabled name="invitation" type="text"
                    class="block w-full" />
            </section>
            <section class="space-y-2">
                <x-form.label for="date" :value="__('budgets.input-date')" />

                <x-form.input id="order_at" name="order_at" type="date" :value="old('order_at', $data->order_at ?? '')" class="block w-full"
                    autocomplete="new-order_at" />

                <x-form.error :messages="$errors->upsertBudget->get('order_at')" />
            </section>
            <section class="space-y-2">
                <x-form.label for="title" :value="__('budgets.input-title')" />

                <x-form.input id="title" :value="old('title', $data->title ?? '')" name="title" :placeholder="__('budgets.input-title-placeholder')" type="text"
                    class="block w-full" autocomplete="new-title" />

                <x-form.error :messages="$errors->upsertBudget->get('title')" />
            </section>
            <section class="space-y-2">
                <x-form.label for="place" :value="__('budgets.input-place')" />

                <x-form.input id="place" :value="old('place', $data->place ?? '')" name="place" :placeholder="__('budgets.input-place-placeholder')" type="text"
                    class="block w-full" autocomplete="new-place" />

                <x-form.error :messages="$errors->upsertBudget->get('place')" />
            </section>
        </section>
    </form>
    <div class="max-w-full flex justify-end">
        <x-button form="budget-form" type="submit" variant="success">บันทึกใบเบิก</x-button>
    </div>
</section>
