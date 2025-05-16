@php
    use Illuminate\Contracts\Auth\MustVerifyEmail;
@endphp

<x-form-section submit="updateProfileInformation">
    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input
                    type="file"
                    id="photo"
                    class="hidden"
                    wire:model.live="photo"
                    x-ref="photo"
                    x-on:change="
                        photoName = $refs.photo.files[0].name
                        const reader = new FileReader()
                        reader.onload = (e) => {
                            photoPreview = e.target.result
                        }
                        reader.readAsDataURL($refs.photo.files[0])
                    "
                />

                <flux:label for="photo">{{ __('Photo') }}</flux:label>

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="size-20 rounded-full object-cover" />
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none">
                    <span
                        class="block size-20 rounded-full bg-cover bg-center bg-no-repeat"
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'"
                    ></span>
                </div>

                <flux:button variant="outline" class="me-2 mt-2" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </flux:button>

                @if ($this->user->profile_photo_path)
                    <flux:button variant="outline" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </flux:button>
                @endif

                <flux:error name="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <flux:input wire:model="state.name" name="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

        <div>
            <flux:input wire:model="state.email" name="email" :label="__('Email')" type="email" required autocomplete="email" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <div>
                    <flux:text class="mt-4">
                        {{ __('Your email address is unverified.') }}

                        <flux:link class="cursor-pointer text-sm" wire:click.prevent="sendEmailVerification">
                            {{ __('Click here to re-send the verification email.') }}
                        </flux:link>
                    </flux:text>

                    @if ($this->verificationLinkSent)
                        <flux:text class="!dark:text-green-400 mt-2 font-medium !text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </flux:text>
                    @endif
                </div>
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full" wire:loading.attr="disabled" wire:target="photo">
                {{ __('Save') }}
            </flux:button>
        </div>

        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>
    </x-slot>
</x-form-section>
