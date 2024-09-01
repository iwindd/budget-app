<x-dropdown align="left" width="48">
    <x-slot name="trigger">
        <button
            class="flex items-center p-2 text-sm font-medium rounded-md transition duration-150 text-inherit ease-in-out hover:text-gray-700 dark:focus:ring-offset-dark-eval-1 dark:hover:text-gray-200"
        >
            <div>{{__("positions.table-action-text")}}</div>

            <div class="ml-1">
                <svg
                    class="w-4 h-4 fill-current"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                >
                    <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                    />
                </svg>
            </div>
        </button>
    </x-slot>

    <x-slot name="content">
        <x-dropdown-link
            href="#"
            x-on:click.prevent="$dispatch('dialog', {
                method: 'patch',
                route: '{{route('positions.update', ['position' => $id])}}',
                value: '{{$label}}'
            })"
            class="flex items-center gap-2"
        >
            <x-heroicon-s-pencil class="w-5 h-5"/><span>{{ __('positions.action-edit') }}</span>
        </x-dropdown-link>
        <x-dropdown-link
            href="#"
            x-on:click="$dispatch('confirmation', {
                target: 'delete-{{$id}}',
                header: '{{ __('positions.delete-confirmation-header', ['position' => $label]) }}',
                text: '{{ __('positions.delete-confirmation-text', ['position' => $label]) }}',
            })"
            class="flex items-center gap-2 "
        >
        <x-heroicon-s-trash class="w-5 h-5"/><span>{{ __('positions.action-delete') }}</span>
        </x-dropdown-link>
        <x-dropdown-link
            :href="route('positions')"
            class="flex items-center gap-2"
        >
            <x-heroicon-s-user class="w-5 h-5"/> <span>{{ __('positions.action-users') }}</span>
        </x-dropdown-link>
        <x-dropdown-link
            :href="route('positions')"
            class="flex items-center gap-2"
        >
            <x-heroicon-o-plus  class="w-5 h-5"/>{{ __('positions.action-created_by') }}
        </x-dropdown-link>
    </x-slot>
</x-dropdown>

<form action="{{ route('positions.destroy', ['position' => $id]) }}" method="POST" id="delete-{{$id}}"> @csrf @method('delete') </form>
