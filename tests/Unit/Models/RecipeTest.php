<?php

declare(strict_types=1);

use App\Enums\Diet;
use App\Enums\Difficulty;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Models\RecipeInstruction;
use App\Models\User;
use App\ValueObjects\Nutrient;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

it('can be created using the factory', function (): void {
    // Act
    $recipe = Recipe::factory()->create();

    // Assert
    expect($recipe)->toBeInstanceOf(Recipe::class)
        ->and($recipe->exists)->toBeTrue();
});

it('has fillable attributes', function (): void {
    // Arrange
    $user = User::factory()->create();
    $data = [
        'title' => 'Test Recipe',
        'description' => 'A test recipe description',
        'preptime' => 15,
        'cooktime' => 30,
        'source' => 'https://example.com/recipe',
        'servings' => 4,
        'difficulty' => Difficulty::MEDIUM,
        'diet' => Diet::VEGETARIAN,
        'cuisine' => 'Italian',
        'user_id' => $user->id,
    ];

    // Act
    $recipe = new Recipe($data);
    $recipe->save();

    // Assert
    expect($recipe->title)->toBe('Test Recipe')
        ->and($recipe->description)->toBe('A test recipe description')
        ->and($recipe->preptime)->toBe(15)
        ->and($recipe->cooktime)->toBe(30)
        ->and($recipe->source)->toBe('https://example.com/recipe')
        ->and($recipe->servings)->toBe(4)
        ->and($recipe->difficulty)->toBe(Difficulty::MEDIUM)
        ->and($recipe->diet)->toBe(Diet::VEGETARIAN)
        ->and($recipe->cuisine)->toBe('Italian')
        ->and($recipe->user_id)->toBe($user->id);
});

it('casts difficulty to enum', function (): void {
    // Arrange
    $recipe = Recipe::factory()->create([
        'difficulty' => 'medium',
    ]);

    // Act & Assert
    expect($recipe->difficulty)->toBeInstanceOf(Difficulty::class)
        ->and($recipe->difficulty)->toBe(Difficulty::MEDIUM);
});

it('casts diet to enum', function (): void {
    // Arrange
    $recipe = Recipe::factory()->create([
        'diet' => 'vegan',
    ]);

    // Act & Assert
    expect($recipe->diet)->toBeInstanceOf(Diet::class)
        ->and($recipe->diet)->toBe(Diet::VEGAN);
});

it('casts tags to array', function (): void {
    // Arrange
    $tags = ['italian', 'pasta', 'quick'];
    $recipe = Recipe::factory()->create([
        'tags' => $tags,
    ]);

    // Act & Assert
    expect($recipe->tags)->toBe($tags);
});

it('casts nutrients to array of Nutrient objects', function (): void {
    // Arrange
    $nutrients = [
        'calories' => 500,
        'protein' => 20,
        'fat' => 15,
    ];

    $recipe = Recipe::factory()->create([
        'nutrients' => $nutrients,
    ]);

    // Act & Assert
    expect($recipe->nutrients)->toBeArray()
        ->and($recipe->nutrients[0])->toBeInstanceOf(Nutrient::class)
        ->and(count($recipe->nutrients))->toBe(3);
});

it('belongs to a user', function (): void {
    // Arrange
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create([
        'user_id' => $user->id,
    ]);

    // Act & Assert
    expect($recipe->user)->toBeInstanceOf(User::class)
        ->and($recipe->user->id)->toBe($user->id);
});

it('has many ingredients', function (): void {
    // Arrange
    $recipe = Recipe::factory()->create();
    $ingredients = RecipeIngredient::factory()->count(3)->create([
        'recipe_id' => $recipe->id,
    ]);

    // Act & Assert
    expect($recipe->ingredients)->toHaveCount(3)
        ->and($recipe->ingredients->first())->toBeInstanceOf(RecipeIngredient::class);
});

it('has many instructions', function (): void {
    // Arrange
    $recipe = Recipe::factory()->create();
    $instructions = RecipeInstruction::factory()->count(3)->create([
        'recipe_id' => $recipe->id,
    ]);

    // Act & Assert
    expect($recipe->instructions)->toHaveCount(3)
        ->and($recipe->instructions->first())->toBeInstanceOf(RecipeInstruction::class);
});

it('orders instructions by position', function (): void {
    // Arrange
    $recipe = Recipe::factory()->create();

    // Create instructions in reverse order
    RecipeInstruction::factory()->create([
        'recipe_id' => $recipe->id,
        'position' => 3,
        'content' => 'Third step',
    ]);

    RecipeInstruction::factory()->create([
        'recipe_id' => $recipe->id,
        'position' => 1,
        'content' => 'First step',
    ]);

    RecipeInstruction::factory()->create([
        'recipe_id' => $recipe->id,
        'position' => 2,
        'content' => 'Second step',
    ]);

    // Act
    $instructions = $recipe->instructions;

    // Assert
    expect($instructions)->toHaveCount(3)
        ->and($instructions[0]->position)->toBe(1)
        ->and($instructions[0]->content)->toBe('First step')
        ->and($instructions[1]->position)->toBe(2)
        ->and($instructions[1]->content)->toBe('Second step')
        ->and($instructions[2]->position)->toBe(3)
        ->and($instructions[2]->content)->toBe('Third step');
});

it('registers a media collection', function (): void {
    // Arrange
    $recipe = Recipe::factory()->create();
    $recipe->registerMediaCollections();

    // Act & Assert
    expect($recipe->getMedia('recipes'))->toBeInstanceOf(MediaCollection::class)
        ->and($recipe->getMedia('recipes')->collectionName)->toBe('recipes');
});
