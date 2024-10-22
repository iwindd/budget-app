<section>
    <header>
        <h2 class="text-lg font-medium">
            {{ __('profile.password-heading') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('profile.password-description') }}
        </p>
    </header>

    <form
        method="post"
        action="{{ route('password.update') }}"
        class="mt-6 space-y-2"
    >
        @csrf
        @method('put')

        <x-textfield
            :label="__('auth.current_password')"
            :startIcon="@svg('heroicon-o-lock-closed')"
            :error="$errors->updatePassword->get('current_password')"
            id="current_password"
            name="current_password"
            type="password"
        />

        <x-textfield
            :label="__('auth.new_password')"
            :startIcon="@svg('heroicon-c-lock-closed')"
            :error="$errors->updatePassword->get('password')"
            id="password"
            name="password"
            type="password"
        />

        <x-textfield
            :label="__('auth.new_password_confirmation')"
            :startIcon="@svg('heroicon-c-lock-closed')"
            :error="$errors->updatePassword->get('password_confirmation')"
            id="password_confirmation"
            name="password_confirmation"
            type="password"
        />

        <div class="flex items-center gap-4">
            <x-button
                variant="success"
            >
                {{ __('profile.save-btn') }}
            </x-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >
                    {{ __('profile.saved-message') }}
                </p>
            @endif
        </div>
    </form>
</section>
