@props([
    'root' => []
])
<section {{ $attributes->only('root')->merge($root) }} wire:ignore>
    <x-textfield
        type="time"
        x-init="
            flatpickr($el, {
                enableTime: true,
                noCalendar: true,
                time_24hr: true,
                minuteIncrement: 5
            });
        "
        {{$attributes}}
    />
</section>
