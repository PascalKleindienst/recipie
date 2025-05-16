<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header
            :title="__('Forgot your password?')"
            :description="__('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.')"
        />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Email Address -->
            <flux:input wire:model="email" :label="__('Email')" type="email" required autofocus placeholder="email@example.com" viewable />

            <flux:button variant="primary" type="submit" class="w-full">{{ __('Email Password Reset Link') }}</flux:button>
        </form>

        <div class="space-x-1 text-center text-sm text-zinc-400 rtl:space-x-reverse">
            <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
        </div>
    </div>
</x-layouts.auth>
