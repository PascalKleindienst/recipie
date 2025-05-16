<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Reset Password')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Email Address -->
            <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

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

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Reset Password') }}
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts.auth>
