@props([
    'options' => [],
    'display' => 'label',
    'value' => 'id',
    'parseInt' => true,
    'debounce' => 250,
    'fetch' => null, // route
    'name' => null,
    'id' => null,
    'label' => null,
    'helper' => null,
    'disabled' => false,
    'placeholder' => null,
    'lang' => null,
    'error' => null,
    'root' => []
])
@php
    $model = $attributes->get('wire:model');
    $fetch = $fetch ? $fetch."?value=$value&label=$display" : null;
    if ($model){
        $id = $id ?? $model;
        $name = $name ?? $model;
        $error = $error ?? $errors->get($model);
    }

    if ($lang){
        $label = $label ?? __($lang);
        $langPlaceholder = "$lang-placeholder";
        $placeholder = $placeholder ?? __($langPlaceholder);
        if ($placeholder == $langPlaceholder) $placeholder = null;
    }
@endphp
<section
    x-data="{
        model: @js($model),
        parseInt: @js($parseInt),
        fetch: @js($fetch),
        value: @entangle($model),
        setValue(value) {
            this.value = (this.parseInt ? Number(value) : value);
        }
    }"
    x-init="() => {
        const selector = $($refs.select);
        selector.select2({
            width: '100%',
            placeholder: @js($placeholder),
            @if ($fetch)
                ajax: {
                    url: @js($fetch),
                    dataType: 'json',
                    delay: @js($debounce),
                    cache: true,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item[@js($display)],
                                    id: item[@js($value)]
                                }
                            })
                        };
                    },
                },
            @endif
        })

        selector.on('select2:select', e => setValue(e.params.data.id));

        const defaultValue = selector.select2('data')[0];
        if (defaultValue) setValue(defaultValue.id);

        $watch('value', raw => {
            const value = String(raw);
            if (!selector.find(`option[value='${value}']`).length && fetch){
                $.ajax({
                    type: 'GET',
                    url: fetch + '&find=' + value
                }).then(function (data) {
                    selector.append(new Option(data[@js($display)], @js($value), false, true)).trigger('change');
                });
            }else{
                selector.val(value).trigger('change')
            }

        });
    }"

    {{ $attributes->only('root')->merge($root) }}
>
    @if ($label)
        <label
            for="{{$id}}"
            class="
                block font-medium text-sm
                {{$error ? 'text-danger' : 'text-gray-700 dark:text-gray-300'}}
            "
        >
            {{ $label }}
        </label>
    @endif

    <div wire:ignore class="mb-1">
        <select
            x-ref="select"
            {!!$attributes->merge([
                'id' => $id,
                'name' => $name,
                'disabled' => $disabled,
            ])!!}
        >
            @if (is_array($options))
                @foreach ($options as $option)
                    <option value="{{$option[$value]}}" {{($option['selected'] ?? false) ? 'selected' : null }}>{{$option[$display]}}</option>
                @endforeach
            @endif
        </select>
    </div>

    @if ($error)
        <ul class="block font-medium text-xs text-danger">
            @foreach ((array) $error as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @else
        @if ($helper)
            <label
                class="
                    block font-medium text-xs
                    {{$error ? 'text-danger' : 'text-gray-700 dark:text-gray-300'}}
                "
            >
                {{ $helper }}
            </label>
        @endif
    @endif
</section>
