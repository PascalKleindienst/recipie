<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Create Account')" :description="__('Enter your details below to create your account')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Name -->
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" :placeholder="__('Full name')" />

            <!-- Email Address -->
            <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" placeholder="email@example.com" />

            <!-- Password -->
            <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                wire:model="password_confirmation"
                :label="__('Confirm Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirm Password')"
                viewable
            />

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <flux:checkbox wire:model="terms" name="terms" id="terms" />
                            <div class="ms-2">
                                {!!
                                    __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="' . route('terms.show') . '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' . __('Terms of Service') . '</a>',
                                        'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' . __('Privacy Policy') . '</a>',
                                    ])
                                !!}
                            </div>
                        </div>
                        <flux:error name="terms" class="mt-2" />
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Register') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 text-center text-sm text-zinc-600 rtl:space-x-reverse dark:text-zinc-400">
            {{ __('Already registered?') }}
            <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
        </div>
    </div>
</x-layouts.auth>
