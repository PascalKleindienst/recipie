<?php

declare(strict_types=1);

use App\Enums\Diet;
use App\Enums\Difficulty;
use App\Models\Recipe;
use App\Models\User;
use App\Services\RecipeService;

describe('getRecipes', function (): void {
    it('returns paginated recipes without filters', function (): void {
        // Arrange
        $user = User::factory()->create();
        $recipes = Recipe::factory()->count(5)->create([
            'user_id' => $user->id,
        ]);
        $service = new RecipeService();

        // Act
        $result = $service->getRecipes();

        // Assert
        expect($result->total())->toBe(5)
            ->and($result->items())->toHaveCount(5);
    });

    it('filters recipes by diet', function (): void {
        // Arrange
        $user = User::factory()->create();

        // Create recipes with different diets
        Recipe::factory()->count(3)->create([
            'user_id' => $user->id,
            'diet' => Diet::VEGAN,
        ]);

        Recipe::factory()->count(2)->create([
            'user_id' => $user->id,
            'diet' => Diet::MEAT,
        ]);

        $service = new RecipeService();

        // Act
        $result = $service->getRecipes(Diet::VEGAN);

        // Assert
        expect($result->total())->toBe(3)
            ->and($result->items())->toHaveCount(3)
            ->and($result->items()[0]->diet)->toBe(Diet::VEGAN);
    });

    it('filters recipes by difficulty', function (): void {
        // Arrange
        $user = User::factory()->create();

        // Create recipes with different difficulties
        Recipe::factory()->count(2)->create([
            'user_id' => $user->id,
            'difficulty' => Difficulty::EASY,
        ]);

        Recipe::factory()->count(3)->create([
            'user_id' => $user->id,
            'difficulty' => Difficulty::HARD,
        ]);

        $service = new RecipeService();

        // Act
        $result = $service->getRecipes(null, Difficulty::HARD);

        // Assert
        expect($result->total())->toBe(3)
            ->and($result->items())->toHaveCount(3)
            ->and($result->items()[0]->difficulty)->toBe(Difficulty::HARD);
    });

    it('filters recipes by both diet and difficulty', function (): void {
        // Arrange
        $user = User::factory()->create();

        // Create recipes with different combinations of diet and difficulty
        Recipe::factory()->count(2)->create([
            'user_id' => $user->id,
            'diet' => Diet::VEGAN,
            'difficulty' => Difficulty::EASY,
        ]);

        Recipe::factory()->count(1)->create([
            'user_id' => $user->id,
            'diet' => Diet::VEGAN,
            'difficulty' => Difficulty::HARD,
        ]);

        Recipe::factory()->count(3)->create([
            'user_id' => $user->id,
            'diet' => Diet::MEAT,
            'difficulty' => Difficulty::MEDIUM,
        ]);

        $service = new RecipeService();

        // Act
        $result = $service->getRecipes(Diet::VEGAN, Difficulty::EASY);

        // Assert
        expect($result->total())->toBe(2)
            ->and($result->items())->toHaveCount(2)
            ->and($result->items()[0]->diet)->toBe(Diet::VEGAN)
            ->and($result->items()[0]->difficulty)->toBe(Difficulty::EASY);
    });

    it('respects the limit parameter', function (): void {
        // Arrange
        $user = User::factory()->create();
        Recipe::factory()->count(10)->create([
            'user_id' => $user->id,
        ]);
        $service = new RecipeService();

        // Act
        $result = $service->getRecipes(null, null, 5);

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

        $service = new RecipeService();

        // Act
        $result = $service->getRecipes();

        // Assert
        expect($result->items()[0]->ingredients_count)->toBe(2);
    });
});
