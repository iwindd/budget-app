<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">
    <x-sidebar.link title="{{ __('dashboard.nav') }}" href="{{ route('dashboard') }}" :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    @if (Auth::user()->role == 'admin')
        <x-sidebar.link title="{{ __('budgets.nav') }}" href="{{ route('budgets.admin') }}" :isActive="Str::startsWith(request()->route()->uri(), 'admin/budgets')">
            <x-slot name="icon">
                <x-heroicon-o-document class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.link title="{{ __('users.nav') }}" href="{{ route('users') }}" :isActive="request()->routeIs('users')">
            <x-slot name="icon">
                <x-heroicon-o-users class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
        <x-sidebar.dropdown title="{{ __('sidebar.document-group') }}" :active="Str::startsWith(request()->route()->uri(), 'admin/document')">
            <x-slot name="icon">
                <x-heroicon-o-circle-stack class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
            <x-sidebar.sublink title="{{ __('positions.nav') }}" href="{{ route('positions') }}" :active="request()->routeIs('positions')"/>
            <x-sidebar.sublink title="{{ __('affiliations.nav') }}" href="{{ route('affiliations') }}" :active="request()->routeIs('affiliations')"/>
            <x-sidebar.sublink title="{{ __('locations.nav') }}" href="{{ route('locations') }}" :active="request()->routeIs('locations')" />
            <x-sidebar.sublink title="{{ __('expenses.nav') }}" href="{{ route('expenses') }}" :active="request()->routeIs('expenses')" />
            <x-sidebar.sublink title="{{ __('offices.nav') }}" href="{{ route('offices') }}" :active="request()->routeIs('offices')" />
            <x-sidebar.sublink title="{{ __('invitations.nav') }}" href="{{ route('invitations') }}"
                :active="request()->routeIs('invitations')" />
        </x-sidebar.dropdown>
    @elseif (Auth::user()->role == 'user')
        <x-sidebar.link title="{{ __('budgets.nav') }}" href="{{ route('budgets') }}" :isActive="Str::startsWith(request()->route()->uri(), 'budgets')">
            <x-slot name="icon">
                <x-heroicon-o-document class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
    @endif
</x-perfect-scrollbar>
