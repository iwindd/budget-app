@props([
    'disabled' => false,
    'placeholder' => null,
    'id' => null,
    'name' => null,
    'startIcon' => null,
    'endIcon' => null,
    'label' => null,
    'helper' => null,
    'error' => null,
    'bag' => null,
    'wrapper' => [],
    'root' => [],
    'lang' => null,
])

@php
    if ($attributes->has('wire:model')){
        $wireModel = $attributes->get('wire:model');
        $id = $id ?? $wireModel;
        $name = $name ?? $wireModel;
        $error = $error ?? $errors->get($wireModel);
    }

    if ($lang){
        $label = $label ?? __($lang);
        if ($label == $lang) $label = '';
        $langPlaceholder = "$lang-placeholder";
        $placeholder = $placeholder ?? __($langPlaceholder);
        if ($placeholder == $langPlaceholder) $placeholder = null;
        $langHelper = "$lang-helper";
        $helper = $helper ?? __($langHelper);
        if ($helper == $langHelper) $helper = null;
    }

    $wrapper['class'] = ($wrapper['class'] ?? ''). "
        flex border rounded-md justify-center items-center overflow-hidden
        " . ($error ? 'border-danger dark:border-danger' : 'border-gray-400 focus-within:border-primary dark:border-gray-600 dark:focus-within:border-primary') . "
        " . ($disabled ? 'bg-gray-200 dark:bg-dark-eval-0' : 'dark:bg-dark-eval-1') ."
        w-full mb-1 gap-2 px-2
    ";
@endphp

<section {{ $attributes->only('root')->merge($root) }}>
    @if ($label)
        <x-form.label :for="$id" :value="$label" :class="$error ? '!text-danger' : ''"/>
    @endif
    <section
        {!!
            $attributes->only('wrapper')->merge($wrapper)
        !!}
    >
        @if ($startIcon)
            <div class="w-6 h-6 text-gray-400 dark:text-gray-600 flex justify-center items-center">
                {{ $startIcon }}
            </div>
        @endif

        <div class="flex-grow">
            <input
                {!!$attributes->merge([
                    'placeholder' => $placeholder,
                    'disabled' => $disabled,
                    'id' => $id,
                    'name' => $name,
                    'class' => 'py-2 px-0 dark:text-gray-300 border-0 ring-0 outline-0 focus:border-0 focus:outline-0 focus:ring-0 w-full bg-inherit',
                ])!!}
            />
        </div>


        @if ($endIcon)
            <div class="w-6 h-6 text-gray-500 flex justify-center items-center">
                {{ $endIcon }}
            </div>
        @endif
    </section>

    @if ($error)
        <x-form.errors :messages="$error"/>
    @elseif ($helper)
        <x-form.helper :for="$id" :value="$helper" :class="$error ? '!text-danger' : ''"/>
    @endif
</section>
