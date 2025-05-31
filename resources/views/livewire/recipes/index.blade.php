@php
    use App\Enums\Diet;
    use App\Enums\Difficulty;
@endphp

<div class="space-y-6">
    <div class="grid grid-cols-3 gap-6">
        <flux:select wire:model.change="diet" :label="__('recipe.fields.diet')">
            <flux:select.option value="">{{ __('Please select') }}</flux:select.option>
            @foreach (Diet::cases() as $diet)
                <flux:select.option :value="$diet->value">{{ $diet->label() }}</flux:select.option>
            @endforeach
        </flux:select>
        <flux:select wire:model.change="difficulty" :label="__('recipe.fields.difficulty')">
            <flux:select.option value="">{{ __('Please select') }}</flux:select.option>
            @foreach (Difficulty::cases() as $difficulty)
                <flux:select.option :value="$difficulty->value">{{ $difficulty->label() }}</flux:select.option>
            @endforeach
        </flux:select>
    </div>

    <div class="grid grid-cols-4 gap-8">
        @forelse ($this->recipes as $recipe)
            <a
                href="{{ route('recipes.show', $recipe) }}"
                @class([
                    'flex flex-col space-y-4 rounded-xl border p-4',
                    'border-rose-400 bg-rose-300' => $recipe->diet === Diet::MEAT,
                    ' border-violet-300 bg-violet-200' => $recipe->diet === Diet::PESCETARIAN,
                    'border-green-400 bg-green-200' => $recipe->diet === Diet::VEGETARIAN,
                    'border-teal-400 bg-teal-200' => $recipe->diet === Diet::VEGAN,
                ])
            >
                @if ($recipe->image)
                    <img src="{{ asset('storage/' . $recipe->image) }}" alt="" class="max-h-48 w-full rounded-xl object-cover" />
                @endif

                <flux:heading size="xl" level="3">{{ $recipe->title }}</flux:heading>
                @if ($recipe->tags)
                    <flux:subheading>{{ implode(',', $recipe->tags) }}</flux:subheading>
                @endif

                <div class="mt-auto space-y-2 space-x-2">
                    <flux:badge icon="timer" size="sm">{{ $recipe->preptime + $recipe->cooktime }} min</flux:badge>
                    <flux:badge icon="shopping-basket" size="sm">{{ $recipe->ingredients_count }} {{ __('recipe.fields.ingredients') }}</flux:badge>
                    <flux:badge icon="academic-cap" size="sm">{{ $recipe->difficulty->label() }}</flux:badge>
                    @if ($recipe->diet)
                        <flux:badge size="sm" :icon="$recipe->diet->icon()">{{ $recipe->diet->label() }}</flux:badge>
                    @endif
                </div>
            </a>
        @empty
            <p>{{ __('recipe.empty') }}</p>
        @endforelse
    </div>

    {{ $this->recipes->links() }}
</div>
