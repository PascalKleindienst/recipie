<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Enums\Diet;
use App\Enums\Difficulty;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Form;

use function count;

final class RecipeFilterForm extends Form
{
    #[Url(as: 'q')]
    #[Validate(['nullable', 'string'])]
    public ?string $search = null;

    /**
     * @var array<string>
     */
    #[Url]
    #[Validate(['nullable', 'array'])]
    public array $tags = [];

    #[Url]
    #[Validate(['nullable'])]
    public ?Diet $diet = null;

    #[Url]
    #[Validate(['nullable'])]
    public ?Difficulty $difficulty = null;

    #[Url]
    #[Validate(['nullable', 'string'])]
    public ?string $cuisine = null;

    public function countActiveFilters(): int
    {
        return count(array_filter([
            $this->tags,
            $this->diet,
            $this->difficulty,
            $this->cuisine,
        ]));
    }

    /**
     * @return array{search: ?string, tags: array<string>, diet: ?Diet, difficulty: ?Difficulty, cuisine: ?string}
     */
    public function toFilter(): array
    {
        return [
            'search' => $this->search,
            'tags' => $this->tags,
            'diet' => $this->diet,
            'difficulty' => $this->difficulty,
            'cuisine' => $this->cuisine,
        ];
    }
}
