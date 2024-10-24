@props([
    'variant' => 'info',
    'text' => '',
    'alert' => null,
    'sr' => null,
    'duration' => null,
    'session' => null,
    'key' => null,
])

@php
    $baseClasses = 'flex items-center justify-between p-4 rounded-lg';

    if ($session) {
        $alert = session()->get($session);
        session()->forget($session);
    }

    if (isset($alert) && !empty($alert) && preg_match('/(\w+)(?:<(\d+)>)?:/', $alert, $matches)) {
        $variant = $matches[1];
        $duration = isset($matches[2]) ? (int) $matches[2] : null;
        $text = trim(str_replace($matches[0], '', $alert));
    }
@endphp

<div x-data="{
    show: @js($text ? true : false),
    sr: @js($sr),
    bag: @js($key),
    text: @js($text),
    variant: @js($variant),
    duration: @js($duration),
    timeoutId: null,
    clearTimeout() {
        if (this.timeoutId) {
            clearTimeout(this.timeoutId); // Clear the existing timeout
        }
    },
    get className() {
        return `alert ${this.variant}`;
    }
}" x-show="show" x-transition x-init="() => duration > 0 ? {timeoutId = setTimeout(() => show = false, duration) }: null"
    x-on:alert.window="() => {
        const alert = $event.detail[0];
        const match = alert.match(/^\[(.+?)\](\w+)<(\d+)>:\s*(.+)$/);
        clearTimeout();
        if (match){
            if (bag != null && bag != match[1]) return;
            variant = match[2];
            duration = parseInt(match[3]);
            text = match[4];
            show = text ? true : false;
            $el.className = className;
            if (duration) timeoutId = setTimeout(() => show = false, duration);
        }else{
            text = alert;
        }
    }"
    :class="className">
    <div class="flex">
        <x-icons.alert />
        <span class="sr-only" x-text="sr"></span>
        <p class="ms-3 text-sm" x-text="text"></p>
    </div>
</div>
