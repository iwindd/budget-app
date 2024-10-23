@props([
    'variant' => 'info',
    'text' => '',
    'alert' => null,
    'sr' => null,
    'duration' => null,
    'session' => null
])

@php
    $baseClasses = 'flex items-center justify-between p-4 rounded-lg';

    if ($session) {
        $alert = session()->get($session);
        session()->forget($session);
    };

    if (isset($alert) && !empty($alert) && preg_match('/(\w+)(?:<(\d+)>)?:/', $alert, $matches)){
        $variant = $matches[1];
        $duration = isset($matches[2]) ? (int)$matches[2] : null;
        $text = trim(str_replace($matches[0], '', $alert));
    }

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

@if (!empty($text))
    <div
        {{ $attributes->merge(['class' => $classes]) }}
        @if ($duration)
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, {{$duration}})"
        @endif
        role="alert">
        <div class="flex">
            <x-icons.alert />
            @if ($sr)
                <span class="sr-only">{{$sr}}</span>
            @endif

            <p class="ms-3 text-sm">
                {!! $text !!}
            </p>
        </div>
    </div>
@endif
