<div class="max-w-7xl space-y-12">
    <div class="relative">
        @if ($recipe->image)
            <img src="{{ asset('storage/' . $recipe->image) }}" alt="" class="[aspect-ratio:3/1] w-full rounded-xl object-cover" />
        @endif

        <h1
            class="absolute bottom-0 flex min-h-lh w-full items-end overflow-hidden rounded-xl bg-gradient-to-b from-zinc-50/0 to-zinc-800 p-2 text-2xl font-bold text-ellipsis text-white md:p-4 md:text-3xl lg:text-4xl xl:text-6xl"
        >
            {{ $recipe->title }}
        </h1>
    </div>

    {{-- Meta Information --}}
    <div class="flex flex-wrap justify-start gap-4 md:justify-between">
        @if ($recipe->cuisine)
            <div class="flex items-center gap-2">
                <flux:icon icon="globe-alt" class="size-10 rounded-full bg-accent p-2 text-accent-foreground md:size-14" />
                <div>
                    <flux:subheading>{{ __('recipe.fields.cuisine') }}</flux:subheading>
                    <flux:heading size="lg">{{ $recipe->cuisine }}</flux:heading>
                </div>
            </div>
        @endif

        <div class="flex items-center gap-2">
            <flux:icon icon="user" class="size-10 rounded-full bg-accent p-2 text-accent-foreground md:size-14" />
            <div>
                <flux:subheading>{{ __('recipe.fields.servings') }}</flux:subheading>
                <flux:heading size="lg">{{ $recipe->servings }}</flux:heading>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <flux:icon icon="timer" class="size-10 rounded-full bg-accent p-2 text-accent-foreground md:size-14" />
            <div>
                <flux:subheading>{{ __('recipe.fields.preptime') }}</flux:subheading>
                <flux:heading size="lg">{{ Number::format($recipe->preptime, locale: app()->getLocale()) }} min</flux:heading>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <flux:icon icon="cooking-pot" class="size-10 rounded-full bg-accent p-2 text-accent-foreground md:size-14" />
            <div>
                <flux:subheading>{{ __('recipe.fields.cooktime') }}</flux:subheading>
                <flux:heading size="lg">{{ Number::format($recipe->cooktime, locale: app()->getLocale()) }} min</flux:heading>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <flux:icon icon="academic-cap" class="size-10 rounded-full bg-accent p-2 text-accent-foreground md:size-14" />
            <div>
                <flux:subheading>{{ __('recipe.fields.difficulty') }}</flux:subheading>
                <flux:heading size="lg">{{ $recipe->difficulty->label() }}</flux:heading>
            </div>
        </div>
    </div>

    <flux:text size="xl">{{ $recipe->description }}</flux:text>

    <flux:button variant="primary" class="cursor-pointer" wire:click="downloadPdf" icon="file-text">
        {{ __('recipe.cta.download_pdf') }}
    </flux:button>

    @if ($recipe->nutrients)
        <section class="space-y-6">
            <flux:heading size="xl" level="3">{{ __('recipe.fields.nutrients') }}</flux:heading>
            <div class="flex flex-wrap gap-2">
                @foreach ($recipe->nutrients as $nutrient)
                    <div class="min-w-16 rounded-xl border border-zinc-300 text-center text-sm">
                        <div class="rounded-t-xl bg-zinc-200 p-2">{{ $nutrient->type->label() }}</div>
                        <div class="p-2">{{ $nutrient->formatAmount() }}</div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Ingredients + Nutrients --}}
    <div class="grid gap-6 md:grid-cols-4">
        <section class="col-span-1 space-y-6">
            <flux:heading size="xl" level="3">{{ __('recipe.fields.ingredients') }}</flux:heading>
            <ul>
                @foreach ($recipe->ingredients as $ingredient)
                    <li class="flex gap-2">
                        <strong class="min-w-16 text-right">{{ $ingredient->amount }} {{ $ingredient->unit }}</strong>
                        {{ $ingredient->name }}
                    </li>
                @endforeach
            </ul>
        </section>

        {{-- Instructions --}}
        <section
            class="col-span-2 space-y-6"
            x-on:instruction-read.window="(event) => loadAndPlay(event.detail.file)"
            x-data="{
                isPlaying: false,
                audio: null,

                loadAndPlay(file) {
                    this.audio = new Audio(file)
                    this.audio.volume = 0.5
                    this.audio.addEventListener('ended', () => (this.isPlaying = false))

                    this.audio
                        .play()
                        .then(() => {
                            this.isPlaying = true
                        })
                        .catch((error) => {
                            console.log('Playback failed:', error)
                        })
                },

                play() {
                    if (! this.audio) {
                        return
                    }

                    this.audio.play()
                    this.isPlaying = true
                },

                pause() {
                    if (! this.audio) {
                        return
                    }

                    this.audio.pause()
                    this.isPlaying = false
                },

                stop() {
                    if (! this.audio) {
                        return
                    }

                    this.audio.pause()
                    this.audio.currentTime = 0
                    this.isPlaying = false
                },
            }"
        >
            <flux:heading size="xl" level="2">
                {{ __('recipe.fields.instructions') }}
            </flux:heading>

            @foreach ($recipe->instructions as $instruction)
                <div class="flex max-w-prose items-center gap-8 rounded-xl bg-zinc-200 p-4">
                    <span class="text-4xl font-semibold text-accent-content">{{ $instruction->position }}</span>
                    <flux:text variant="strong" size="lg">
                        {!! \Illuminate\Support\Str::markdown($instruction->content) !!}
                    </flux:text>

                    <div>
                        <flux:button
                            x-show="isPlaying"
                            variant="ghost"
                            icon="stop"
                            square
                            class="cursor-pointer"
                            x-on:click="stop"
                            :aria-label="__('recipe.cta.stop_reading')"
                        ></flux:button>

                        <flux:button
                            x-show="! isPlaying"
                            variant="ghost"
                            icon="play"
                            square
                            class="cursor-pointer"
                            wire:click="readInstruction({{ $instruction->id }})"
                            :aria-label="__('recipe.cta.read_instruction')"
                        ></flux:button>
                    </div>
                </div>
            @endforeach
        </section>
    </div>
</div>
