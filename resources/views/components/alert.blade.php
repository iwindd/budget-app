@props([
    'variant' => 'info',
    'text' => '',
])

@php
    $baseClasses = 'flex items-center justify-between p-4 rounded-lg bg-inherit';

    switch ($variant) {
        case 'primary':
            $variantClasses = 'text-purple-500 bg-purple-500/20';
            break;
        case 'secondary':
            $variantClasses = 'text-gray-500 bg-gray-500/20';
            break;
        case 'success':
            $variantClasses = 'text-green-500 bg-green-500/20';
            break;
        case 'danger':
            $variantClasses = 'text-red-500 bg-red-500/20';
            break;
        case 'warning':
            $variantClasses = 'text-yellow-500 bg-yellow-500/20';
            break;
        case 'info':
            $variantClasses = 'text-cyan-500 bg-cyan-500/20';
            break;
        case 'black':
            $variantClasses = 'text-black bg-black/20';
            break;
        default:
            $variantClasses = 'text-purple-500 bg-purple/20';
    }

    $classes = $baseClasses . ' ' . $variantClasses;
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}
    role="alert">
    <div class="flex">
        <x-icons.alert />
        <span class="sr-only">ข้อมูลเพิ่มเติม</span>

        <p class="ms-3 text-sm">
            {{ $text }}
        </p>
    </div>
</div>
