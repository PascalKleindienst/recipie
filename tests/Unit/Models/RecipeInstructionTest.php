<?php

declare(strict_types=1);

use App\Models\Recipe;
use App\Models\RecipeInstruction;

it('can be created using the factory', function (): void {
    // Act
    $instruction = RecipeInstruction::factory()->create();

    // Assert
    expect($instruction)->toBeInstanceOf(RecipeInstruction::class)
        ->and($instruction->exists)->toBeTrue();
});

it('has the expected attributes', function (): void {
    // Arrange
    $recipe = Recipe::factory()->create();
    $instruction = RecipeInstruction::factory()->create([
        'recipe_id' => $recipe->id,
        'position' => 2,
        'content' => 'Mix all ingredients together',
        'image' => 'mixing.jpg',
    ]);

    // Act & Assert
    expect($instruction->position)->toBe(2)
        ->and($instruction->content)->toBe('Mix all ingredients together')
        ->and($instruction->image)->toBe('mixing.jpg')
        ->and($instruction->recipe_id)->toBe($recipe->id);
});

it('belongs to a recipe', function (): void {
    // Arrange
    $recipe = Recipe::factory()->create();
    $instruction = RecipeInstruction::factory()->create([
        'recipe_id' => $recipe->id,
    ]);

    // Act & Assert
    expect($instruction->recipe)->toBeInstanceOf(Recipe::class)
        ->and($instruction->recipe->id)->toBe($recipe->id);
});

it('can have a null image', function (): void {
    // Arrange & Act
    $instruction = RecipeInstruction::factory()->create([
        'image' => null,
    ]);

    // Assert
    expect($instruction->image)->toBeNull();
});
