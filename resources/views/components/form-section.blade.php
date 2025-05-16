@props([
    'submit',
    'title' => null,
    'description' => null,
])

<div {{ $attributes->merge(['class' => '']) }}>
    <div class="max-md:pt-6">
        <flux:heading>{{ $title ?? '' }}</flux:heading>
        <flux:subheading>{{ $description ?? '' }}</flux:subheading>
    </div>

    <div class="mt-5 w-full max-w-lg">
        <form wire:submit="{{ $submit }}">
            <div class="my-6 w-full space-y-6">
                {{ $form }}
            </div>

            @if (isset($actions))
                <div class="flex items-center gap-4">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
