@props([
    'disabled' => false,
    'withicon' => false
])

@php
    $withiconClasses = $withicon ? 'pl-11 pr-4' : 'px-4'
@endphp

<input
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
            'class' => $withiconClasses . ' py-2 border-gray-400 rounded-md focus:border-gray-400 focus:ring
            focus:ring-primary-400/50 focus:ring-offset-0 focus:ring-offset-white dark:border-gray-600 dark:bg-dark-eval-1
            dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 disabled:bg-gray-200 dark:disabled:bg-dark-eval-0',
        ])
    !!}
>
