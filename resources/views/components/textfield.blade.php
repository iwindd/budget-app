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
    $wrapper['class'] = ($wrapper['class'] ?? ''). "
        flex border rounded-md justify-center items-center overflow-hidden
        " . ($error ? 'border-danger dark:border-danger' : 'border-gray-400 focus-within:border-primary dark:border-gray-600 dark:focus-within:border-primary') . "
        " . ($disabled ? 'bg-gray-200 dark:bg-dark-eval-0' : 'dark:bg-dark-eval-1') ."
        w-full
        gap-2 px-2 mb-1
    ";

    if ($attributes->has('wire:model')){
        $wireModel = $attributes->get('wire:model');
        $id = $id ?? $wireModel;
        $name = $name ?? $wireModel;
        $error = $error ?? $errors->get($wireModel);
    }

    if ($lang){
        $label = $label ?? __($lang);
        $langPlaceholder = "$lang-placeholder";
        $placeholder = $placeholder ?? __($langPlaceholder);
        if ($placeholder == $langPlaceholder) $placeholder = null;
    }
@endphp

<section {{ $attributes->only('root')->merge($root) }}>
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

        <input
            {!!$attributes->merge([
                'placeholder' => $placeholder,
                'disabled' => $disabled,
                'id' => $id,
                'name' => $name,
                'class' => 'py-2 px-0 dark:text-gray-300 border-0 ring-0 outline-0 focus:border-0 focus:outline-0 focus:ring-0 flex-grow bg-inherit',
            ])!!}
        />

        @if ($endIcon)
            <div class="w-6 h-6 text-gray-500 flex justify-center items-center">
                {{ $endIcon }}
            </div>
        @endif
    </section>

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
