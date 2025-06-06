<?php

declare(strict_types=1);

namespace App\Livewire\Recipes;

use App\Models\Recipe;
use App\Models\RecipeInstruction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use PascalKleindienst\LaravelTextToSpeech\Facades\TextToSpeech;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class Show extends Component
{
    public Recipe $recipe;

    public ?string $speech = null;

    public function downloadPdf(): StreamedResponse
    {
        return response()->streamDownload(function () {
            echo Pdf::loadView('livewire.recipes.pdf', [
                'recipe' => $this->recipe,
            ])->output();
        }, Str::slug($this->recipe->title).'.pdf');
    }

    #[Renderless]
    public function readInstruction(RecipeInstruction $instruction): void
    {
        if (Storage::disk(config('text-to-speech.audio.disk'))->exists(TextToSpeech::engine('google')->getFilePath($instruction->content))) {
            $this->dispatch('instruction-read', file: asset('storage/'.TextToSpeech::engine('google')->getFilePath($instruction->content)));

            return;
        }

        $this->dispatch('instruction-read', file: asset('storage/'.TextToSpeech::engine('google')->convert($instruction->content)->file));
    }

    public function render(): View
    {
        return view('livewire.recipes.show');
    }
}
