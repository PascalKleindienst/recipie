<?php

declare(strict_types=1);

use App\Enums\NutrientType;
use App\ValueObjects\Nutrient;

it('can be created from an array', function (): void {
    // Arrange
    $data = [
        'type' => 'calories',
        'amount' => 100,
    ];

    // Act
    $nutrient = new Nutrient($data);

    // Assert
    expect($nutrient->type)->toBe(NutrientType::CALORIES)
        ->and($nutrient->amount)->toBe(100.0);
});

it('can format the amount with the correct unit', function (): void {
    // Arrange
    $caloriesNutrient = new Nutrient([
        'type' => 'calories',
        'amount' => 100,
    ]);

    $proteinNutrient = new Nutrient([
        'type' => 'protein',
        'amount' => 20,
    ]);

    // Act & Assert
    expect($caloriesNutrient->formatAmount())->toBe('100 kcal')
        ->and($proteinNutrient->formatAmount())->toBe('20 g');
});

it('can be converted to an array', function (): void {
    // Arrange
    $nutrient = new Nutrient([
        'type' => 'fat',
        'amount' => 15.5,
    ]);

    // Act
    $array = $nutrient->toArray();

    // Assert
    expect($array)->toBe([
        'type' => 'fat',
        'amount' => 15.5,
    ]);
});

it('can be serialized to JSON', function (): void {
    // Arrange
    $nutrient = new Nutrient([
        'type' => 'carbs',
        'amount' => 30,
    ]);

    // Act
    $json = json_encode($nutrient);

    // Assert
    expect($json)->toBe('{"type":"carbs","amount":30}');
});
