@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'block font-medium text-xs text-danger']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
