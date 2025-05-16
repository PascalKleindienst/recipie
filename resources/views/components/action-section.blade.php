@props(['title' => null, 'description' => null])
<div {{ $attributes->merge(['class' => 'space-y-6']) }}>
    <div class="max-md:pt-6">
        <flux:heading>{{ $title ?? '' }}</flux:heading>
        <flux:subheading>{{ $description ?? '' }}</flux:subheading>
    </div>

    <div class="mt-6 md:col-span-2 md:mt-0">
        {{ $content }}
    </div>
</div>
