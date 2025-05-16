<x-layouts.auth>
    <div class="flex flex-col gap-6" x-data="{ recovery: false }">
        <x-auth-header
            x-show="! recovery"
            :title="__('Two Factor Authentication')"
            :description="__('Please confirm access to your account by entering the authentication code provided by your authenticator application.')"
        />
        <x-auth-header
            x-show="recovery"
            x-cloak
            :title="__('Two Factor Authentication')"
            :description="__('Please confirm access to your account by entering one of your emergency recovery codes.')"
        />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('two-factor.login') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Code -->
            <div x-show="! recovery">
                <flux:input
                    wire:model="code"
                    :label="__('Code')"
                    type="text"
                    inputmode="numeric"
                    autocomplete="one-time-code"
                    autofocus
                    x-ref="code"
                />
            </div>

            <!-- Recovery Code -->
            <div x-show="recovery" x-cloak>
                <flux:input
                    wire:model="recovery_code"
                    :label="__('Recovery Code')"
                    type="text"
                    inputmode="numeric"
                    autocomplete="one-time-code"
                    autofocus
                    x-ref="recovery_code"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <flux:button
                    variant="ghost"
                    class="w-full"
                    x-show="! recovery"
                    x-on:click="
                        recovery = true
                        $nextTick(() => {
                            $refs.recovery_code.focus()
                        })
                    "
                >
                    {{ __('Use a recovery code') }}
                </flux:button>

                <flux:button
                    variant="ghost"
                    type="button"
                    x-cloak
                    x-show="recovery"
                    x-on:click="
                        recovery = false
                        $nextTick(() => {
                            $refs.code.focus()
                        })
                    "
                >
                    {{ __('Use an authentication code') }}
                </flux:button>

                <flux:button variant="primary" type="submit" class="ms-4">
                    {{ __('Log in') }}
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts.auth>
