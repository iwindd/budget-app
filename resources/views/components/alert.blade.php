@props([
    'variant' => 'info',
    'text' => '',
    'sr' => null
])

@php
    $baseClasses = 'flex items-center justify-between p-4 rounded-lg';

    switch ($variant) {
        case 'primary':
            $variantClasses = 'text-primary bg-primary-400/15';
            break;
        case 'secondary':
            $variantClasses = 'text-secondary bg-secondary-400/15';
            break;
        case 'success':
            $variantClasses = 'text-success bg-success-400/15';
            break;
        case 'danger':
            $variantClasses = 'text-danger bg-danger-400/15';
            break;
        case 'warning':
            $variantClasses = 'text-warning bg-warning-400/15';
            break;
        case 'info':
            $variantClasses = 'text-info bg-info-400/15';
            break;
        case 'black':
            $variantClasses = 'text-black bg-black/15';
            break;
        default:
            $variantClasses = 'text-primary bg-primary-400/15';
    }

    $classes = $baseClasses . ' ' . $variantClasses;
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}
    role="alert">
    <div class="flex">
        <x-icons.alert />
        @if ($sr)
            <span class="sr-only">{{$sr}}</span>
        @endif

        <p class="ms-3 text-sm">
            {{ $text }}
        </p>
    </div>
</div>
