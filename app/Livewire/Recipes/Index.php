<?php

declare(strict_types=1);

namespace App\Livewire\Recipes;

use App\Enums\Diet;
use App\Enums\Difficulty;
use App\Models\Recipe;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

final class Index extends Component
{
    use WithoutUrlPagination;
    use WithPagination;

    public ?Diet $diet = null;

    public ?Difficulty $difficulty = null;

    /**
     * @return LengthAwarePaginator<int, Recipe>
     */
    #[Computed]
    public function recipes(): LengthAwarePaginator
    {
        return Recipe::query()
            ->withCount('ingredients')
            ->when($this->diet, fn ($query, $diet) => $query->where('diet', $diet))
            ->when($this->difficulty, fn ($query, $difficulty) => $query->where('difficulty', $difficulty))
            ->paginate(25);
    }

    public function render(): View
    {
        return view('livewire.recipes.index');
    }
}
