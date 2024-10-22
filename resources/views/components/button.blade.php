@props([
    'variant' => 'primary',
    'iconOnly' => false,
    'srText' => '',
    'href' => false,
    'size' => 'base',
    'disabled' => false,
    'pill' => false,
    'squared' => false
])

@php

    $baseClasses = 'flex transition-colors font-medium select-none disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus:ring focus:ring-offset-0 focus:ring-offset-white dark:focus:ring-offset-dark-eval-2';

    switch ($variant) {
        case 'primary':
            $variantClasses = 'bg-primary text-white hover:bg-primary-600 focus:ring-primary-400/50';
        break;
        case 'secondary':
            $variantClasses = 'bg-transparent text-secondary hover:bg-secondary/10 focus:ring-0';
        break;
        case 'success':
            $variantClasses = 'bg-success text-white hover:bg-success-600 focus:ring-success-400/50';
        break;
        case 'danger':
            $variantClasses = 'bg-danger text-white hover:bg-danger-600 focus:ring-danger-400/50';
        break;
        case 'warning':
            $variantClasses = 'bg-warning text-white hover:bg-warning-600 focus:ring-warning-400/50';
        break;
        case 'info':
            $variantClasses = 'bg-info text-white hover:bg-info-600 focus:ring-info-400/50';
        break;
        case 'black':
            $variantClasses = 'bg-black text-gray-300 hover:text-white hover:bg-gray-800 focus:ring-black dark:hover:bg-dark-eval-3';
        break;
        default:
            $variantClasses = 'bg-primary text-white hover:bg-primary-600 focus:ring-primary-400/50';
    }

    switch ($size) {
        case 'sm':
            $sizeClasses = $iconOnly ? 'p-1.5' : 'px-2.5 py-1.5 text-sm';
        break;
        case 'base':
            $sizeClasses = $iconOnly ? 'p-2' : 'px-4 py-2 text-base';
        break;
        case 'lg':
        default:
            $sizeClasses = $iconOnly ? 'p-3' : 'px-5 py-2 text-xl';
        break;
    }

    $classes = $baseClasses . ' ' . $sizeClasses . ' ' . $variantClasses;

    if(!$squared && !$pill){
        $classes .= ' rounded-md';
    } else if ($pill) {
        $classes .= ' rounded-full';
    }

@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
        @if($iconOnly)
            <span class="sr-only">{{ $srText ?? '' }}</span>
        @endif
    </a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => $classes]) }}>
        {{ $slot }}
        @if($iconOnly)
            <span class="sr-only">{{ $srText ?? '' }}</span>
        @endif
    </button>
@endif
