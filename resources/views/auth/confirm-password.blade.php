<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header
            :title="__('Confirm Password')"
            :description="__('This is a secure area of the application. Please confirm your password before continuing.')"
        />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.confirm') }}" class="flex flex-col gap-6">
            @csrf

            <flux:input
                wire:model="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                viewable
            />

            <flux:button variant="primary" type="submit" class="w-full">{{ __('Confirm') }}</flux:button>
        </form>
    </div>
</x-layouts.auth>
