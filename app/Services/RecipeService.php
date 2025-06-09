<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Diet;
use App\Enums\Difficulty;
use App\Models\Recipe;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

use function sprintf;

final readonly class RecipeService
{
    /**
     * @param  array{search?: ?string, tags?: array<string>, diet?: ?Diet, difficulty?: ?Difficulty, cuisine?: ?string}  $filter
     * @return LengthAwarePaginator<int, Recipe>
     */
    public function getRecipes(array $filter = [], int $limit = 25): LengthAwarePaginator
    {
        $filter['search'] ??= null;
        $filter['tags'] ??= [];
        $filter['diet'] ??= null;
        $filter['difficulty'] ??= null;
        $filter['cuisine'] ??= null;

        return Recipe::query()
            ->withCount('ingredients')
            ->when($filter['search'], fn (Builder $query, string $search) => $query->where(static fn (Builder $query) => $query->whereLike('title', sprintf('%%%s%%', $search))->orWhereLike('description', sprintf('%%%s%%', $search))))
            ->when($filter['cuisine'], fn (Builder $query, string $cuisine) => $query->whereCuisine($cuisine))
            ->when($filter['diet'], fn (Builder $query, Diet $diet) => $query->where('diet', $diet))
            ->when($filter['difficulty'], fn (Builder $query, Difficulty $difficulty) => $query->where('difficulty', $difficulty))
            ->when($filter['tags'], fn (Builder $query, array $tags) => $query->where(
                fn (Builder $query) => $query->tap(static fn (Builder $query) => Arr::map($tags, static fn (string $tag) => $query->whereJsonContains('tags', $tag, 'or')))
            ))
            ->orderBy('title')
            ->paginate($limit);
    }

    /**
     * @return string[]
     */
    public function getTags(): array
    {
        return Recipe::all()->pluck('tags')->flatten(1)->unique()->sortBy(static fn (string $tag) => strtolower($tag))->toArray();
    }

    /**
     * @return string[]
     */
    public function getCuisines(): array
    {
        return Recipe::query()->distinct()->whereNotNull('cuisine')->orderBy('cuisine')->get('cuisine')->pluck('cuisine')->toArray();
    }
}
