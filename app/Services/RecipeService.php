<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Diet;
use App\Enums\Difficulty;
use App\Models\Recipe;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

final readonly class RecipeService
{
    /**
     * @return LengthAwarePaginator<int, Recipe>
     */
    public function getRecipes(?Diet $diet = null, ?Difficulty $difficulty = null, int $limit = 25): LengthAwarePaginator
    {
        return Recipe::query()
            ->withCount('ingredients')
            ->when($diet, fn (Builder $query, Diet $diet) => $query->where('diet', $diet))
            ->when($difficulty, fn (Builder $query, Difficulty $difficulty) => $query->where('difficulty', $difficulty))
            ->paginate($limit);
    }
}
