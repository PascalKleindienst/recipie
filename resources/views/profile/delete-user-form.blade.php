<x-action-section
    :title="__('Delete Account')"
    :description="__('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.')"
>
    <x-slot name="content">
        <flux:modal.trigger name="confirm-user-deletion">
            <flux:button variant="danger" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
                {{ __('Delete Account') }}
            </flux:button>
        </flux:modal.trigger>

        <flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
            <form wire:submit="deleteUser" class="space-y-6">
                <div>
                    <flux:heading size="lg">
                        {{ __('Delete Account') }}
                    </flux:heading>

                    <flux:subheading>
                        {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </flux:subheading>
                </div>

                <flux:input
                    wire:model="password"
                    :label="__('Password')"
                    type="password"
                    autofocus
                    autocomplete="current-password"
                    wire:keydown.enter="deleteUser"
                />

                <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                    <flux:modal.close>
                        <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                    </flux:modal.close>

                    <flux:button variant="danger" wire:click="deleteUser" wire:loading.attr="disabled">
                        {{ __('Delete Account') }}
                    </flux:button>
                </div>
            </form>
        </flux:modal>
    </x-slot>
</x-action-section>
