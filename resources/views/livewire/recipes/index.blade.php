<?php

declare(strict_types=1);

use App\Enums\Diet;
use App\Enums\Difficulty;
use App\Facades\RecipeService;
use App\Livewire\Forms\RecipeFilterForm;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

new class extends Component {
    use WithoutUrlPagination;
    use WithPagination;

    public RecipeFilterForm $form;

    #[Computed]
    public function tags(): array
    {
        return RecipeService::getTags();
    }

    #[Computed]
    public function cuisines(): array
    {
        return RecipeService::getCuisines();
    }

    #[Computed]
    public function recipes(): LengthAwarePaginator
    {
        return RecipeService::getRecipes($this->form->toFilter());
    }

    public function clearFilters(): void
    {
        $this->form->reset();
    }
};
?>

<div class="space-y-6">
    <div class="flex items-end gap-6">
        <flux:input
            type="search"
            icon="magnifying-glass"
            class="flex-1"
            wire:model.live.debounce="form.search"
            :aria-label="__('recipe.fields.search')"
            :placeholder="__('recipe.fields.search')"
        />

        <flux:modal.trigger name="edit-filters">
            <flux:button icon="adjustments-horizontal" class="relative cursor-pointer" aria-label="Filter" x-on:click="open = ! open">
                @if ($this->form->countActiveFilters())
                    <flux:badge variant="solid" color="green" size="sm" class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2">
                        {{ $this->form->countActiveFilters() }}
                    </flux:badge>
                @endif
            </flux:button>
        </flux:modal.trigger>

        <flux:modal name="edit-filters" variant="flyout" class="w-full md:max-w-md">
            <div class="grid grid-cols-1 items-end gap-6">
                <div
                    x-on:click.away="open = false"
                    x-data="{
                        open: false,
                        toggle(tag) {
                            if ($wire.form.tags.includes(tag)) {
                                $wire.form.tags.splice($wire.form.tags.indexOf(tag), 1)
                                $wire.$refresh()
                                return
                            }

                            $wire.form.tags.push(tag)
                            $wire.$refresh()
                        },
                    }"
                    class="relative space-y-2"
                >
                    <flux:label for="tags">{{ __('recipe.fields.tags') }}</flux:label>

                    <div class="mt-2">
                        <flux:button class="flex h-auto min-h-10 w-full flex-wrap justify-start gap-2 py-2" x-on:click="open = ! open">
                            @foreach ($this->form->tags as $tag)
                                <flux:badge size="sm" icon="x-mark" x-on:click="toggle('{{ $tag }}')">
                                    <span>{{ $tag }}</span>
                                </flux:badge>
                            @endforeach
                        </flux:button>
                    </div>

                    <div
                        x-show="open"
                        x-transition
                        class="absolute z-10 w-full rounded-lg border border-zinc-200 bg-white py-2 ps-3 pe-3 shadow-xs"
                    >
                        @foreach ($this->tags as $tag)
                            <flux:button
                                variant="ghost"
                                size="sm"
                                class="block w-full justify-start"
                                x-on:click="toggle('{{ $tag }}')"
                                :icon="\in_array($tag, $this->form?->tags, true) ? 'check' : 'plus'"
                            >
                                {{ $tag }}
                            </flux:button>
                        @endforeach
                    </div>
                </div>
                <flux:select wire:model.change="form.cuisine" :label="__('recipe.fields.cuisine')">
                    <flux:select.option value="">{{ __('Please select') }}</flux:select.option>
                    @foreach ($this->cuisines as $cuisine)
                        <flux:select.option :value="$cuisine">{{ $cuisine }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:select wire:model.change="form.diet" :label="__('recipe.fields.diet')">
                    <flux:select.option value="">{{ __('Please select') }}</flux:select.option>
                    @foreach (Diet::cases() as $diet)
                        <flux:select.option :value="$diet->value">{{ $diet->label() }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:select wire:model.change="form.difficulty" :label="__('recipe.fields.difficulty')">
                    <flux:select.option value="">{{ __('Please select') }}</flux:select.option>
                    @foreach (Difficulty::cases() as $difficulty)
                        <flux:select.option :value="$difficulty->value">{{ $difficulty->label() }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:button wire:click="clearFilters" variant="ghost" class="w-full">
                    {{ __('recipe.actions.clear-filters') }}
                </flux:button>
            </div>
        </flux:modal>
    </div>

    <div class="grid grid-cols-4 gap-8">
        @forelse ($this->recipes as $recipe)
            <a
                href="{{ route('recipes.show', $recipe) }}"
                @class([
                    'flex flex-col space-y-4 rounded-xl border p-4',
                    'border-rose-400/50 bg-rose-300/50' => $recipe->diet === Diet::MEAT,
                    'border-violet-300/50 bg-violet-200/50' => $recipe->diet === Diet::PESCETARIAN,
                    'border-green-400/50 bg-green-200/50' => $recipe->diet === Diet::VEGETARIAN,
                    'border-teal-400/50 bg-teal-200/50' => $recipe->diet === Diet::VEGAN,
                ])
            >
                @if ($recipe->hasMedia('recipes'))
                    <figure class="[&>img]:[aspect-ratio:3/1] [&>img]:w-full [&>img]:overflow-hidden [&>img]:rounded-xl [&>img]:object-cover">
                        {{ $recipe->getFirstMedia('recipes') }}
                    </figure>
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
