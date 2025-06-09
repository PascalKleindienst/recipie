<?php

declare(strict_types=1);

use App\Enums\Diet;
use App\Enums\Difficulty;
use App\Models\Recipe;
use App\Models\User;
use App\Services\RecipeService;
use Pest\Expectation;

beforeEach(function (): void {
    $this->service = new RecipeService();
});

describe('getRecipes', function (): void {
    it('returns paginated recipes without filters', function (): void {
        // Arrange
        $user = User::factory()->create();
        Recipe::factory()->count(5)->create([
            'user_id' => $user->id,
        ]);

        // Act
        $result = $this->service->getRecipes();

        // Assert
        expect($result->total())->toBe(5)
            ->and($result->items())->toHaveCount(5);
    });

    it('filters recipes by', function (array $filters): void {
        // Arrange
        $user = User::factory()->create();

        // Create recipes with different diets
        Recipe::factory()->count(3)->create([
            'user_id' => $user->id,
            'title' => 'Recipe '.random_int(1, 3),
            'diet' => Diet::VEGAN,
            'difficulty' => Difficulty::HARD,
            'cuisine' => 'Italian',
            'tags' => ['foo', 'bar'],
        ]);

        Recipe::factory()->count(2)->create([
            'user_id' => $user->id,
            'diet' => Diet::MEAT,
            'difficulty' => Difficulty::EASY,
            'cuisine' => 'Asian',
            'tags' => ['baz'],
        ]);

        // Act
        $result = $this->service->getRecipes($filters);

        // Assert
        expect($result->total())->toBe(3)->and($result->items())->toHaveCount(3);
        \Illuminate\Support\Arr::mapWithKeys($filters, static fn ($value, $key): Expectation => expect($result->items()[0]->$key)->toBe($value));
    })->with([
        'diet' => [['diet' => Diet::VEGAN]],
        'difficulty' => [['difficulty' => Difficulty::HARD]],
        'cuisine' => [['cuisine' => 'Italian']],
        'tags' => [['tags' => ['foo', 'bar']]],
        'multiple' => [['diet' => Diet::VEGAN, 'difficulty' => Difficulty::HARD]],
    ]);

    it('respects the limit parameter', function (): void {
        // Arrange
        $user = User::factory()->create();
        Recipe::factory()->count(10)->create([
            'user_id' => $user->id,
        ]);

        // Act
        $result = $this->service->getRecipes(limit: 5);

        // Assert
        expect($result->perPage())->toBe(5)
            ->and($result->items())->toHaveCount(5);
    });

    it('includes ingredient count', function (): void {
        // Arrange
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create([
            'user_id' => $user->id,
        ]);

        // Create some ingredients for the recipe
        $recipe->ingredients()->create([
            'name' => 'Ingredient 1',
            'amount' => 1,
            'unit' => 'cup',
        ]);

        $recipe->ingredients()->create([
            'name' => 'Ingredient 2',
            'amount' => 2,
            'unit' => 'tbsp',
        ]);

        // Act
        $result = $this->service->getRecipes();

        // Assert
        expect($result->items()[0]->ingredients_count)->toBe(2);
    });

    it('filters by search term', function (): void {
        // Arrange
        $user = User::factory()->create();
        $recipes = Recipe::factory()->count(5)->create([
            'user_id' => $user->id,
        ]);

        // Act
        $result = $this->service->getRecipes(['search' => $recipes[0]->title]);

        // Assert
        expect($result->items())->toHaveCount(1)->and($result->items()[0]->id)->toBe($recipes[0]->id);
    });
});

it('gets all unique tags', function (): void {
    // Arrange
    $user = User::factory()->create();
    $tags = ['italian', 'pasta', 'quick', 'italian', 'pasta', 'quick', 'italian', 'pasta', 'quick', 'italian', 'pasta', 'quick', 'italian', 'pasta', 'quick'];
    Recipe::factory()->count(5)->create([
        'user_id' => $user->id,
        'tags' => $tags,
    ]);

    // Act
    $result = $this->service->getTags();

    // Assert
    expect($result)->toBe([
        'italian',
        'pasta',
        'quick',
    ]);
});

it('gets all unique cuisines', function (): void {
    // Arrange
    $user = User::factory()->create();
    $cuisines = ['italian', 'asian', 'italian', 'korean'];
    \Illuminate\Support\Arr::map($cuisines, static fn ($cuisine) => Recipe::factory()->create([
        'user_id' => $user->id,
        'cuisine' => $cuisine,
    ]));

    // Act
    $result = $this->service->getCuisines();

    // Assert
    expect($result)->toBe([
        'asian',
        'italian',
        'korean',
    ]);
});
