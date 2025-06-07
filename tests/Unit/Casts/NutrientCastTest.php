<?php

declare(strict_types=1);

use App\Casts\NutrientCast;
use App\Models\Recipe;
use App\ValueObjects\Nutrient;

it('can cast from JSON to Nutrient objects', function (): void {
    // Arrange
    $cast = new NutrientCast();
    $model = new Recipe();
    $value = json_encode([
        'calories' => 500,
        'protein' => 20,
        'fat' => 15,
    ]);

    // Act
    $result = $cast->get($model, 'nutrients', $value, []);

    // Assert
    expect($result)->toBeArray()
        ->and($result)->toHaveCount(3)
        ->and($result[0])->toBeInstanceOf(Nutrient::class)
        ->and($result[0]->type->value)->toBe('calories')
        ->and($result[0]->amount)->toBe(500.0);
});

it('returns null for empty values', function (): void {
    // Arrange
    $cast = new NutrientCast();
    $model = new Recipe();

    // Act & Assert
    expect($cast->get($model, 'nutrients', null, []))->toBeNull()
        ->and($cast->get($model, 'nutrients', '', []))->toBeNull();
});

it('skips null or empty string nutrient values', function (): void {
    // Arrange
    $cast = new NutrientCast();
    $model = new Recipe();
    $value = json_encode([
        'calories' => 500,
        'protein' => null,
        'fat' => '',
        'carbs' => 30,
    ]);

    // Act
    $result = $cast->get($model, 'nutrients', $value, []);

    // Assert
    expect($result)->toBeArray()
        ->and($result)->toHaveCount(2)
        ->and($result[0]->type->value)->toBe('calories')
        ->and($result[1]->type->value)->toBe('carbs');
});

it('can cast from Nutrient objects to JSON', function (): void {
    // Arrange
    $cast = new NutrientCast();
    $model = new Recipe();
    $nutrients = [
        new Nutrient(['type' => 'calories', 'amount' => 500]),
        new Nutrient(['type' => 'protein', 'amount' => 20]),
    ];

    // Act
    $result = $cast->set($model, 'nutrients', $nutrients, []);

    // Assert
    expect($result)->toBeString()
        ->and(json_decode($result, true))->toBe([
            ['type' => 'calories', 'amount' => 500],
            ['type' => 'protein', 'amount' => 20],
        ]);
});
