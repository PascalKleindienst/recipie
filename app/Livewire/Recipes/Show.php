<?php

declare(strict_types=1);

namespace App\Livewire\Recipes;

use App\Models\Recipe;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class Show extends Component
{
    public Recipe $recipe;

    public function downloadPdf(): StreamedResponse
    {
        return response()->streamDownload(function () {
            echo Pdf::loadView('livewire.recipes.pdf', [
                'recipe' => $this->recipe,
            ])->output();
        }, Str::slug($this->recipe->title).'.pdf');
    }

    public function render(): View
    {
        return view('livewire.recipes.show');
    }
}
