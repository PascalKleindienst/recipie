<x-layouts.auth>
    <div class="mt-4 flex flex-col gap-6">
        <flux:text class="text-center">
            {{ __('Please click the button below to verify your email address.') }}
        </flux:text>

        @if (session('status') === 'verification-link-sent')
            <flux:text class="!dark:text-green-400 text-center font-medium !text-green-600">
                {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
            </flux:text>
        @endif

        <div class="flex flex-col items-center justify-between space-y-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Resend Verification Email') }}
                </flux:button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <flux:link type="submit" class="cursor-pointer text-sm">
                    {{ __('Log out') }}
                </flux:link>
            </form>
        </div>
    </div>
</x-layouts.auth>
