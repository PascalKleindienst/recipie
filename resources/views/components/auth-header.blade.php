@props([
    'title',
    'description',
])

<div {{ $attributes->merge(['class' => 'flex w-full flex-col text-center']) }}>
    <flux:heading size="xl">{{ $title ?? '' }}</flux:heading>
    <flux:subheading>{{ $description ?? '' }}</flux:subheading>
</div>
