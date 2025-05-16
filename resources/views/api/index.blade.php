<x-layouts.app>
    @include('partials.settings-heading')

    <x-settings.layout
        :heading="__('Create API Token')"
        :subheading="__('API tokens allow third-party services to authenticate with our application on your behalf.')"
    >
        @livewire('api.api-token-manager')
    </x-settings.layout>
</x-layouts.app>
