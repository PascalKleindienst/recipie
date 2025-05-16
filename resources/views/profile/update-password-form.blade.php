<x-form-section submit="updatePassword">
    <x-slot name="form">
        <flux:input
            wire:model="state.current_password"
            name="current_password"
            :label="__('Current Password')"
            type="password"
            required
            autocomplete="current-password"
        />
        <flux:input wire:model="state.password" name="password" :label="__('New Password')" type="password" required autocomplete="new-password" />
        <flux:input
            wire:model="state.password_confirmation"
            name="password_confirmation"
            :label="__('Confirm Password')"
            type="password"
            required
            autocomplete="new-password"
        />
    </x-slot>

    <x-slot name="actions">
        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
        </div>

        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>
    </x-slot>
</x-form-section>
