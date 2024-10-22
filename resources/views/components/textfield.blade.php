@props([
    'disabled' => false,
    'placeholder' => '',
    'id' => '',
    'startIcon' => null,
    'endIcon' => null,
    'label' => null,
    'helper' => null,
    'error' => null,
    'bag' => null,
    'wrapperProps' => []
])

@php
    $wrapperClasses = "
        flex border rounded-md justify-center items-center dark:bg-dark-eval-1 dark:disabled:bg-dark-eval-0 overflow-hidden
        " . ($error ? 'border-danger dark:border-danger' : 'border-gray-400 focus-within:border-primary dark:border-gray-600 dark:focus-within:border-primary') . "
        disabled:bg-gray-200 w-full
        gap-2 px-2
    ";
@endphp

<section>
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
            $attributes->only($wrapperProps)->merge([
                'class' => $wrapperClasses
            ])
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
                'class' => 'py-2 px-0 dark:text-gray-300 border-0 ring-0 outline-0 focus:border-0 focus:outline-0 focus:ring-0 flex-grow',
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
