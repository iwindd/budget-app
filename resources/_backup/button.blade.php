@props([
    'variant' => 'primary',
    'size' => 'base',
    'disabled' => false,
    'iconOnly' => false,
    'srText' => '',
    'href' => null,
    'pill' => false,
    'squared' => false,
])

@if (isset($href))
    <a href="{{ $href }}">
@endif

<button x-data="{
    variant: @js($variant),
    size: @js($size),
    disabled: @js($disabled),
    srText: @js($srText),
    iconOnly: @js($iconOnly),
    pill: @js($pill),
    squared: @js($squared),
    getVariantClass() {
        switch (this.variant) {
            case 'black':
                return 'bg-black text-gray-300 hover:text-white hover:bg-gray-800 focus:ring-black dark:hover:bg-dark-eval-3';
            case 'secondary':
                return 'bg-transparent text-secondary hover:bg-secondary/10 focus:ring-0';
            default:
                return `bg-${this.variant} text-white hover:bg-${this.variant}-600 focus:ring-${this.variant}-400/50`;
        }
    },
    getSizeClass() {
        switch (this.size) {
            case 'sm':
                return this.iconOnly ? 'p-1.5' : 'px-2.5 py-1.5 text-sm';
            case 'base':
                return this.iconOnly ? 'p-2' : 'px-4 py-2 text-base';
            default:
                return this.iconOnly ? 'p-3' : 'px-5 py-2 text-xl';
        }
    },
    getRoundedClass() {
        return !this.squared && !this.pill ? 'rounded-md' : this.pill ? 'rounded-full' : ''
    },
    get className() {
        const base = `flex transition-colors font-medium select-none disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus:ring focus:ring-offset-0 focus:ring-offset-white dark:focus:ring-offset-dark-eval-2`;
        const variant = this.getVariantClass();
        const size = this.getSizeClass();
        const rounded = this.getRoundedClass();
        return `${base} ${variant} ${size} ${rounded}`;
    }
}" :class="className" {{ $attributes }}>
    {{ $slot }}
    @if ($iconOnly)
        <span class="sr-only" x-text="srText"></span>
    @endif
</button>

@if (isset($href))
    </a>
@endif
