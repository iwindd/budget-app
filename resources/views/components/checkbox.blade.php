@props([
    'label' => '',
    'variant' => 'primary',
    'error' => null,
    'id' => null,
    'name' => null,
    'disabled' => false,
    'root' => [],
])

@php
    if ($attributes->has('wire:model')){
        $wireModel = $attributes->get('wire:model');
        $id = $id ?? $wireModel;
        $name = $name ?? $wireModel;
        $error = $error ?? $errors->get($wireModel);
    }

    $inputClass = "text-$variant border-gray-300 rounded focus:border-$variant-300 focus:ring-offset-0 focus:ring focus:ring-$variant-400/50 dark:border-gray-600 dark:bg-dark-eval-1 dark:focus:ring-offset-dark-eval-1";
@endphp

<section {{ $attributes->only('root')->merge($root) }}>
    <section class="flex items-center justify-between">
        <label for="{{$id}}" class="inline-flex items-center">
            <input
                {!!$attributes->merge([
                    'disabled'  => $disabled,
                    'id'        => $id,
                    'name'      => $name,
                    'type'      => 'checkbox',
                    'class'     => $inputClass,
                ])!!}
            >
            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400 ">
                {{$label}}
            </span>
        </label>
    </section>

    @if ($error)
        <ul class="block font-medium text-xs text-danger">
            @foreach ((array) $error as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @endif
</section>
