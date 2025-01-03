<x-guest-layout>
    <x-auth-card title="เข้าสู่ระบบ">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="grid gap-4">
                <!-- Email Address -->
                <x-textfield
                    :label="__('auth.email')"
                    :startIcon="@svg('heroicon-o-envelope')"
                    :value="old('email')"
                    id="email"
                    type="email"
                    name="email"
                    placeholder="{{ __('auth.email') }}"
                    required
                    autofocus
                    :error="$errors->get('email')"
                />

                <!-- Password -->
                <x-textfield
                    :label="__('auth.password')"
                    :startIcon="@svg('heroicon-o-lock-closed')"
                    id="password"
                    type="password"
                    name="password"
                    value=""
                    required
                    placeholder="{{ __('auth.password') }}"
                    autocomplete="false"
                />

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <x-checkbox
                        :label="__('auth.rememberme')"
                        name="remember"
                        id="remember_me"
                    />

                    @if (Route::has('password.request'))
                        <a class="text-sm text-primary hover:underline" href="{{ route('password.request') }}">
                            {{ __('auth.forgot_password') }}
                        </a>
                    @endif
                </div>

                <div>
                    <x-button class="justify-center w-full gap-2">
                        <x-heroicon-o-arrow-left-end-on-rectangle class="w-6 h-6" aria-hidden="true" />

                        <span>{{ __('auth.login') }}</span>
                    </x-button>
                </div>

                @if (Route::has('register'))
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Don’t have an account?') }}
                        <a href="{{ route('register') }}" class="text-primary hover:underline">
                            {{ __('Register') }}
                        </a>
                    </p>
                @endif
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
