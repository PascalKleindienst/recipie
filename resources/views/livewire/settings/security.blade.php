<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Security')">
        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
            <div class="mt-10 sm:mt-0">
                @livewire('profile.two-factor-authentication-form')
            </div>
        @endif

        <div class="mt-10 sm:mt-0">
            @livewire('profile.logout-other-browser-sessions-form')
        </div>
    </x-settings.layout>
</section>
