<div class="space-y-8">
    <!-- Generate API Token -->
    <x-form-section submit="createApiToken">
        <x-slot name="form">
            <!-- Token Name -->
            <div class="col-span-6 sm:col-span-4">
                <flux:input type="text" name="name" :label="__('Token Name')" wire:model="createApiTokenForm.name" autofocus />
            </div>

            <!-- Token Permissions -->
            @if (Laravel\Jetstream\Jetstream::hasPermissions())
                <div class="col-span-6">
                    <flux:checkbox.group wire:model="createApiTokenForm.permissions" :label="__('Permissions')">
                        @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                            <flux:checkbox wire:model="" :label="$permission" :value="$permission" />
                        @endforeach
                    </flux:checkbox.group>
                </div>
            @endif
        </x-slot>

        <x-slot name="actions">
            <flux:button variant="primary" type="submit">
                {{ __('Create') }}
            </flux:button>

            <x-action-message class="me-3" on="created">
                {{ __('Created.') }}
            </x-action-message>
        </x-slot>
    </x-form-section>

    @if ($this->user->tokens->isNotEmpty())
        <flux:separator variant="subtle" />

        <!-- Manage API Tokens -->
        <x-action-section
            class="mt-10 sm:mt-0"
            :title="__('Manage API Tokens')"
            :description="__('You may delete any of your existing tokens if they are no longer needed.')"
        >
            <!-- API Token List -->
            <x-slot name="content">
                <div class="space-y-6">
                    @foreach ($this->user->tokens->sortBy('name') as $token)
                        <div class="flex items-center justify-between">
                            <div class="break-all">
                                {{ $token->name }}
                            </div>

                            <div class="ms-2 flex items-center gap-2">
                                @if ($token->last_used_at)
                                    <div class="text-sm text-gray-400">{{ __('Last used') }} {{ $token->last_used_at->diffForHumans() }}</div>
                                @endif

                                @if (Laravel\Jetstream\Jetstream::hasPermissions())
                                    <flux:button variant="ghost" class="cursor-pointer" wire:click="manageApiTokenPermissions({{ $token->id }})">
                                        {{ __('Permissions') }}
                                    </flux:button>
                                @endif

                                <flux:button variant="danger" wire:click="confirmApiTokenDeletion({{ $token->id }})">
                                    {{ __('Delete') }}
                                </flux:button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-slot>
        </x-action-section>
    @endif

    <!-- Token Value Modal -->
    <flux:modal wire:model.live="displayingToken" dismissible="false">
        <div class="space-y-6">
            <flux:heading>{{ __('API Token') }}</flux:heading>
            <flux:subheading>{{ __('Please copy your new API token. For your security, it won\'t be shown again.') }}</flux:subheading>

            <flux:input
                x-ref="plaintextToken"
                type="text"
                readonly
                :value="$plainTextToken"
                autofocus
                autocomplete="off"
                autocorrect="off"
                autocapitalize="off"
                spellcheck="false"
                copyable
                @showing-token-modal.window="setTimeout(() => $refs.plaintextToken.select(), 250)"
            />
        </div>
    </flux:modal>

    <!-- API Token Permissions Modal -->
    <flux:modal wire:model.live="managingApiTokenPermissions" class="md:min-w-md">
        <div class="space-y-6">
            <flux:heading>{{ __('API Token Permissions') }}</flux:heading>

            <flux:checkbox.group wire:model="updateApiTokenForm.permissions" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                    <flux:checkbox :label="$permission" :value="$permission" />
                @endforeach
            </flux:checkbox.group>

            <div class="flex gap-2">
                <flux:button variant="primary" wire:click="updateApiToken" wire:loading.attr="disabled">
                    {{ __('Save') }}
                </flux:button>

                <flux:button variant="outline" wire:click="$set('managingApiTokenPermissions', false)" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

    <!-- Delete Token Confirmation Modal -->
    <flux:modal wire:model.live="confirmingApiTokenDeletion">
        <div class="space-y-6">
            <flux:heading>{{ __('Delete API Token') }}</flux:heading>
            <flux:subheading>{{ __('Are you sure you would like to delete this API token?') }}</flux:subheading>

            <div class="flex gap-2">
                <flux:button variant="danger" wire:click="deleteApiToken" wire:loading.attr="disabled">
                    {{ __('Delete') }}
                </flux:button>

                <flux:button variant="outline" wire:click="$toggle('confirmingApiTokenDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
