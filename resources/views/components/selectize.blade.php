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
    'root' => [],
    'selectOnClose' => false,
    'defaultByOptions' => false
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

    $root['class'] = ($root['class'] ?? ''). ($error ? ' select-invalid' : '') ;
@endphp
<section
    x-data="{
        model: @js($model),
        parseInt: @js($parseInt),
        parseCreate: @js($parseCreate),
        fetch: @js($fetch),
        multiple: @js($multiple),
        options: @js($options),
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
        },
        cachedQueries : {}
    }"
    x-init="() => {
        const selector = $($refs.select);
        selector.select2({
            width: '100%',
            tags: create,
            placeholder: @js($placeholder),
            multiple: @js($multiple),
            selectOnClose: @js($selectOnClose),
            @if ($fetch)
                ajax: {
                    delay: @js($debounce),
                    transport: function (params, success, failure) {
                        const searchTerm = params.data.term || '';

                        if  (cachedQueries[searchTerm]) {
                            success({ results: cachedQueries[searchTerm] });
                        } else {
                            $.ajax({
                                url: @js($fetch),
                                method: 'GET',
                                dataType: 'json',
                                data: {
                                    q: searchTerm,
                                },
                                success: function (data) {
                                    cachedQueries[searchTerm] = data;
                                    success({ results: data });
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    failure(errorThrown);
                                },
                            });
                        }
                    },
                    processResults: function(data) {
                        if (!data) return {result: []}
                        return {
                            results: data.results.map(item => ({
                                text: item[@js($display)],
                                id: item[@js($value)]
                            }))
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
        }).on('select2:unselect', e => {
            setValue(selector.val())
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

        @if (!$defaultByOptions)
            const currentValue = defaultValue ? defaultValue : selector.select2('data')[0]?.id;
            if (currentValue) updateOption(currentValue);
            if (currentValue) setValue(currentValue);
        @else
            const selected = [];

            options.map(op => {
                if (op.selected) selected.push(op.id)
            })

            selector.val(selected).trigger('change')
        @endif

        $watch('value', updateOption);
    }"

    {{ $attributes->only('root')->merge($root) }}
>
    @if ($label)
        <x-form.label :for="$id" :value="$label" :class="$error ? '!text-danger' : ''"/>
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
        <x-form.errors :messages="$error"/>
    @elseif ($helper)
        <x-form.helper :for="$id" :value="$helper" :class="$error ? '!text-danger' : ''"/>
    @endif


</section>
