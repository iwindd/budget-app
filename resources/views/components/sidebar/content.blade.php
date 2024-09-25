<x-perfect-scrollbar
    as="nav"
    aria-label="main"
    class="flex flex-col flex-1 gap-4 px-3"
>
    <x-sidebar.link
        title="Dashboard"
        href="{{ route('dashboard') }}"
        :isActive="request()->routeIs('dashboard')"
    >
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    @if (Auth::user()->role == "admin")
        <x-sidebar.link
            title="{{__('budgets.nav')}}"
            href="{{ route('budgets.admin') }}"
            :isActive="request()->routeIs('budgets.admin')"
        >
            <x-slot name="icon">
                <x-heroicon-o-document class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link
            title="{{__('users.nav')}}"
            href="{{ route('users') }}"
            :isActive="request()->routeIs('users')"
        >
            <x-slot name="icon">
                <x-heroicon-o-users class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link
            title="{{__('positions.nav')}}"
            href="{{ route('positions') }}"
            :isActive="request()->routeIs('positions')"
        >
            <x-slot name="icon">
                <x-heroicon-o-puzzle-piece class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link
            title="{{__('affiliations.nav')}}"
            href="{{ route('affiliations') }}"
            :isActive="request()->routeIs('affiliations')"
        >
            <x-slot name="icon">
                <x-heroicon-o-tag class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link
            title="{{__('locations.nav')}}"
            href="{{ route('locations') }}"
            :isActive="request()->routeIs('locations')"
        >
            <x-slot name="icon">
                <x-heroicon-c-paper-airplane class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link
            title="{{__('expenses.nav')}}"
            href="{{ route('expenses') }}"
            :isActive="request()->routeIs('expenses')"
        >
            <x-slot name="icon">
                <x-heroicon-o-banknotes class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link
            title="{{__('offices.nav')}}"
            href="{{ route('offices') }}"
            :isActive="request()->routeIs('offices')"
        >
            <x-slot name="icon">
                <x-heroicon-o-building-office-2 class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link
            title="{{__('invitations.nav')}}"
            href="{{ route('invitations') }}"
            :isActive="request()->routeIs('invitations')"
        >
            <x-slot name="icon">
                <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
    @elseif (Auth::user()->role == "user")
        <x-sidebar.link
            title="{{__('budgets.nav')}}"
            href="{{ route('budgets') }}"
            :isActive="request()->routeIs('budgets')"
        >
            <x-slot name="icon">
                <x-heroicon-o-document class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
    @endif
</x-perfect-scrollbar>
