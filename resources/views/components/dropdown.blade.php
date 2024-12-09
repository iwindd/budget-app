@props([
    'position' => 'bottom',
    /*
        Bottom: .bottom, .bottom-start, .bottom-end
        Top:    .top,    .top-start,    .top-end
        Left:   .left,   .left-start,   .left-end
        Right:  .right,  .right-start,  .right-end
    */
    'width' => '48',
    'contentClasses' => 'py-1 bg-white dark:bg-dark-eval-2',
])

@php
    switch ($width) {
        case '48':
            $width = 'w-48';
            break;
        case '96':
            $width = 'w-96';
            break;
    }
@endphp

<div
    class="relative"
    x-data="{ open: false, triggerPosition: {} }"
    x-on:click.away="open = false"
    x-on:close.stop="open = false"
    x-on:close-dropdown.window="open = false"
>
    <div x-ref="button" x-on:click="open = ! open">
        {{ $trigger }}
    </div>

    @teleport('#teleport-wrapper')
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg"
            style="display: none;"
            x-on:click="open = false"

            x-anchor.{{$position}}="$refs.button"
        >
            <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
                {{ $content }}
            </div>
        </div>
    @endteleport('#teleport-wrapper')
</div>
