@props([
    'options' => [],
    'display' => 'label',
    'value' => 'id',
    'parseInt' => true,
    'parseCreate' => false,
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
    'defaultValue' => null,
    'create' => false,
    'multiple' => false,
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
        if ($label == $lang) $label = '';
        $langPlaceholder = "$lang-placeholder";
        $placeholder = $placeholder ?? __($langPlaceholder);
        if ($placeholder == $langPlaceholder) $placeholder = null;
    }
@endphp
<section
    x-data="{
        model: @js($model),
        parseInt: @js($parseInt),
        parseCreate: @js($parseCreate),
        fetch: @js($fetch),
        multiple: @js($multiple),
        create: @js($create),
        defaultValue: @js($parseInt ? intval($defaultValue) : $defaultValue),
        value: @entangle($model),
        setValue(value, isCreate) {
            if (this.parseInt) value = typeof(value) == 'object' ? value.map(v => +v) : +value;
            if (isCreate && this.parseCreate && this.create){
                this.value = JSON.stringify({
                    create: true,
                    value: value
                });
            }else{
                this.value = value
            }
        }
    }"
    x-init="() => {
        const selector = $($refs.select);
        selector.select2({
            width: '100%',
            tags: create,
            placeholder: @js($placeholder),
            multiple: @js($multiple),
            selectOnClose: true,
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
            @if($create)
                createTag: function (params) {
                    var term = $.trim(params.term);
                    if (term === '') return null;

                    return {
                        id: term,
                        text: term,
                        create: true
                    }
                }
            @endif
        }).on('select2:select', e => {
            setValue(selector.val(), e.params?.data?.create)
        });

        const updateOption = (raw) => {
            if (!multiple) {
                const value = String(raw);
                if (raw != null && !selector.find(`option[value='${value}']`).length && fetch){
                    let findValue = value;

                    try {
                        const isNew = JSON.parse(findValue);
                        findValue = isNew.value;

                        return
                    } catch (e) {
                        findValue = value;
                    }

                    findValue = $.trim(findValue);
                    if (findValue === '') return null;

                    $.ajax({
                        type: 'GET',
                        url: fetch + '&find=' + findValue
                    }).then(function (data) {
                        selector.append(new Option(data[@js($display)], @js($value), false, true)).trigger('change');
                    });
                }else{
                    selector.val(value).trigger('change')
                }
            }
        }

        const currentValue = defaultValue ? defaultValue : selector.select2('data')[0]?.id;
        if (currentValue) updateOption(currentValue);
        if (currentValue) setValue(currentValue);

        $watch('value', updateOption);
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
