@props(['title' => __('Confirm Password'), 'content' => __('For your security, please confirm your password to continue.'), 'button' => __('Confirm')])

@php
    $confirmableId = md5($attributes->wire('then'));
@endphp

<span
    {{ $attributes->wire('then') }}
    x-data
    x-ref="span"
    x-on:click="$wire.startConfirmingPassword('{{ $confirmableId }}')"
    x-on:password-confirmed.window="
        setTimeout(
            () =>
                $event.detail.id === '{{ $confirmableId }}' &&
                $refs.span.dispatchEvent(new CustomEvent('then', { bubbles: false })),
            250,
        )
    "
>
    {{ $slot }}
</span>

@once
    <flux:modal name="confirm-password" wire:model.live="confirmingPassword" focusable class="max-w-lg space-y-4">
        <flux:heading size="lg">{{ $title }}</flux:heading>

        {{ $content }}

        <div class="mt-4">
            <flux:input
                type="password"
                name="confirmable_password"
                class="mt-1 block w-3/4"
                placeholder="{{ __('Password') }}"
                autocomplete="current-password"
                wire:model="confirmablePassword"
                wire:keydown.enter="confirmPassword"
                autofocus
            />
            <flux:error name="confirmable_password" />
        </div>

        <div class="mt-2">
            <flux:button variant="outline" wire:click="stopConfirmingPassword" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </flux:button>
            <flux:button variant="primary" class="ms-3" dusk="confirm-password-button" wire:click="confirmPassword" wire:loading.attr="disabled">
                {{ $button }}
            </flux:button>
        </div>
    </flux:modal>
@endonce
