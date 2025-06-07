<?php

declare(strict_types=1);

use App\Enums\NutrientType;

it('has the expected cases', function (): void {
    // Assert
    expect(NutrientType::cases())->toHaveCount(6)
        ->and(NutrientType::CALORIES->value)->toBe('calories')
        ->and(NutrientType::CARBS->value)->toBe('carbs')
        ->and(NutrientType::FAT->value)->toBe('fat')
        ->and(NutrientType::PROTEIN->value)->toBe('protein')
        ->and(NutrientType::FIBER->value)->toBe('fiber')
        ->and(NutrientType::SUGAR->value)->toBe('sugar');
});

it('can be created from string value', function (): void {
    // Act & Assert
    expect(NutrientType::from('calories'))->toBe(NutrientType::CALORIES)
        ->and(NutrientType::from('carbs'))->toBe(NutrientType::CARBS)
        ->and(NutrientType::from('fat'))->toBe(NutrientType::FAT)
        ->and(NutrientType::from('protein'))->toBe(NutrientType::PROTEIN)
        ->and(NutrientType::from('fiber'))->toBe(NutrientType::FIBER)
        ->and(NutrientType::from('sugar'))->toBe(NutrientType::SUGAR);
});

it('provides a label', function (): void {
    // Arrange
    $nutrientType = NutrientType::CALORIES;

    // Act
    $label = $nutrientType->label();

    // Assert
    // Since the label uses translation, we can't test the exact string
    // but we can test that it returns a string
    expect($label)->toBeString();
});
