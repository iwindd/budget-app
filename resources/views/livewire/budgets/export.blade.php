<div>
    <x-dropdown position="bottom" width="96">
        <x-slot name="trigger">
            <button
                class="flex items-center p-2 text-sm font-medium text-gray-500 rounded-md transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark-eval-1 dark:text-gray-400 dark:hover:text-gray-200">
                <div>{{ __('exports.export-dropdown-btn') }}</div>

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
            <x-dropdown-link target="_blank" :href="route('budgets.export.document', ['budget' => $budget])">
                {{ __('exports.export-document-btn:owner') }}
            </x-dropdown-link>
            <x-dropdown-link target="_blank" :href="route('budgets.export.evidence', ['budget' => $budget])">
                {{ __('exports.export-evidence-btn') }}
            </x-dropdown-link>
            <x-dropdown-link target="_blank" :href="route('budgets.export.certificate', ['budget' => $budget])">
                {{ __('exports.export-certificate-btn') }}
            </x-dropdown-link>
            <x-dropdown-link target="_blank" :href="route('budgets.export.travel', ['budget' => $budget])" class="border-b">
                {{ __('exports.export-travel-btn') }}
            </x-dropdown-link>
            @foreach ($budget->companions as $companion)
                <x-dropdown-link
                    target="_blank"
                    :href="route('budgets.export.document', [
                        'budget' => $budget,
                        'of' => $companion->user_id
                    ])"
                >
                    {{ __('exports.export-document-btn', ['name' => $companion->user->name]) }}
                </x-dropdown-link>
            @endforeach
        </x-slot>
    </x-dropdown>
</div>
