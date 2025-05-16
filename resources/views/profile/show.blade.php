<x-layouts.app>
    <section class="w-full">
        @include('partials.settings-heading')

        <x-settings.layout :heading="__('Profile Information')" :subheading="__('Update your account\'s profile information and email address.')">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')
            @endif

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <div class="mt-10">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </x-settings.layout>
    </section>
</x-layouts.app>
