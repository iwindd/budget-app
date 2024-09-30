@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white dark:bg-dark-eval-2',
    'teleport' => false,
])

@php
    switch ($align) {
        case 'left':
            $alignmentClasses = 'origin-top-left left-0';
            break;
        case 'top':
            $alignmentClasses = 'origin-top';
            break;
        case 'right':
        default:
            $alignmentClasses = 'origin-top-right right-0';
            break;
    }

    switch ($width) {
        case '48':
            $width = 'w-48';
            break;
    }
@endphp

<div class="relative" x-data="{ open: false, triggerPosition: {} }" x-on:click.away="open = false" x-on:close.stop="open = false"
    x-init="$watch('open', value => {
        if (value) {
            const triggerEl = $el.querySelector('[x-on\\:click]');
            triggerPosition = triggerEl.getBoundingClientRect();
        }
    });">
    <div x-on:click="open = ! open">
        {{ $trigger }}
    </div>

    @if ($teleport)
        @teleport('#teleport-wrapper')
    @endif
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }}"
        style="display: none;"
        @if ($teleport) x-bind:style="`top: ${triggerPosition.bottom + window.scrollY}px; left: ${triggerPosition.left + window.scrollX}px; `" @endif
        x-on:click="open = false">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
    @if ($teleport)
        @endteleport('#teleport-wrapper')
    @endif

</div>
