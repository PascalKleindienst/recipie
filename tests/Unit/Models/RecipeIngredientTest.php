<?php

declare(strict_types=1);

use App\Models\Recipe;
use App\Models\RecipeIngredient;

it('can be created using the factory', function (): void {
    // Act
    $ingredient = RecipeIngredient::factory()->create();

    // Assert
    expect($ingredient)->toBeInstanceOf(RecipeIngredient::class)
        ->and($ingredient->exists)->toBeTrue();
});

it('has the expected attributes', function (): void {
    // Arrange
    $recipe = Recipe::factory()->create();
    $ingredient = RecipeIngredient::factory()->create([
        'recipe_id' => $recipe->id,
        'name' => 'Flour',
        'amount' => 2.5,
        'unit' => 'cups',
    ]);

    // Act & Assert
    expect($ingredient->name)->toBe('Flour')
        ->and($ingredient->amount)->toBe(2.5)
        ->and($ingredient->unit)->toBe('cups')
        ->and($ingredient->recipe_id)->toBe($recipe->id);
});

it('belongs to a recipe', function (): void {
    // Arrange
    $recipe = Recipe::factory()->create();
    $ingredient = RecipeIngredient::factory()->create([
        'recipe_id' => $recipe->id,
    ]);

    // Act & Assert
    expect($ingredient->recipe)->toBeInstanceOf(Recipe::class)
        ->and($ingredient->recipe->id)->toBe($recipe->id);
});

it('can have a null amount', function (): void {
    // Arrange & Act
    $ingredient = RecipeIngredient::factory()->create([
        'amount' => null,
    ]);

    // Assert
    expect($ingredient->amount)->toBeNull();
});

it('can have a null unit', function (): void {
    // Arrange & Act
    $ingredient = RecipeIngredient::factory()->create([
        'unit' => null,
    ]);

    // Assert
    expect($ingredient->unit)->toBeNull();
});
