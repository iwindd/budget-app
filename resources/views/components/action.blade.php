<section>
    <x-dropdown position="bottom-start" width="48">
        <x-slot name="trigger">
            <button
                class="flex items-center p-2 text-sm font-medium rounded-md transition duration-150 text-inherit ease-in-out hover:text-gray-700 dark:focus:ring-offset-dark-eval-1 dark:hover:text-gray-200">
                <div>{{$attributes['label']}}</div>

                <div class="ml-1">
                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </button>
        </x-slot>

        <x-slot name="content">
            @foreach ($attributes['options'] as $option)
                @php
                    $attributes = new Illuminate\View\ComponentAttributeBag($option['attributes'] ?? []);
                    $attributes = $attributes->merge(['class' => "flex items-center gap-2 cursor-pointer"]);

                    if (isset($option['dispatch'])) {
                        [$dispatchKey, $dispatchArgs] = $option['dispatch'];
                        $attributes = $attributes->merge([
                            'x-on:click.prevent' => "\$dispatch('$dispatchKey', " . json_encode($dispatchArgs) . ")"
                        ]);
                    }
                @endphp
                <x-dropdown-link {{$attributes}}>
                    @isset($option['icon'])
                        <div class="w-5 h-5">@svg($option['icon'])</div>
                    @endisset

                    <span>{{$option['label']}}</span>
                </x-dropdown-link>
            @endforeach
        </x-slot>
    </x-dropdown>

</section>
