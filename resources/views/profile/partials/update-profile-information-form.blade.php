<section>
    <header>
        <h2 class="text-lg font-medium">
            {{ __('profile.information-heading') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("profile.information-description") }}
        </p>
    </header>

    <form
        method="post"
        action="{{ route('profile.update') }}"
        class="mt-6 space-y-2"
    >
        @csrf
        @method('patch')

        <x-textfield
            :label="__('auth.name')"
            :value="old('name', $user->name)"
            :startIcon="@svg('heroicon-o-user')"
            :error="$errors->get('name')"
            id="name"
            name="name"
            type="text"
            required
            autocomplete="name"
        />

        <div class="grid grid-cols-2 gap-2">
            <x-textfield
                :label="__('positions.label')"
                :value="$user->position->label"
                type="text"
                disabled
            />
            <x-textfield
                :label="__('affiliations.label')"
                :value="$user->affiliation->label"
                type="text"
                disabled
            />
        </div>

        <x-textfield
            :label="__('auth.email')"
            :value="$user->email"
            :startIcon="@svg('heroicon-o-envelope')"
            :error="$errors->get('email')"
            id="email"
            name="email"
            type="email"
            required
            autocomplete="email"
            disabled
        />

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-300">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500  dark:text-gray-400 dark:hover:text-gray-200 dark:focus:ring-offset-gray-800">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-success-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-button
                variant="success"
            >
                {{ __('profile.save-btn') }}
            </x-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 5000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >
                    {{ __('profile.saved-message') }}
                </p>
            @endif
        </div>
    </form>
</section>
