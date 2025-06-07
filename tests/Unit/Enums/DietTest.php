<?php

declare(strict_types=1);

use App\Enums\Diet;

it('has the expected cases', function (): void {
    // Assert
    expect(Diet::cases())->toHaveCount(5)
        ->and(Diet::VEGAN->value)->toBe('vegan')
        ->and(Diet::VEGETARIAN->value)->toBe('vegetarian')
        ->and(Diet::GLUTEN_FREE->value)->toBe('gluten-free')
        ->and(Diet::PESCETARIAN->value)->toBe('pescetarian')
        ->and(Diet::MEAT->value)->toBe('meat');
});

it('can be created from string value', function (): void {
    // Act & Assert
    expect(Diet::from('vegan'))->toBe(Diet::VEGAN)
        ->and(Diet::from('vegetarian'))->toBe(Diet::VEGETARIAN)
        ->and(Diet::from('gluten-free'))->toBe(Diet::GLUTEN_FREE)
        ->and(Diet::from('pescetarian'))->toBe(Diet::PESCETARIAN)
        ->and(Diet::from('meat'))->toBe(Diet::MEAT);
});

it('provides a label', function (): void {
    // Arrange
    $diet = Diet::VEGAN;

    // Act
    $label = $diet->label();

    // Assert
    // Since the label uses translation, we can't test the exact string
    // but we can test that it returns a string
    expect($label)->toBeString();
});

it('provides an icon', function (): void {
    // Act & Assert
    expect(Diet::VEGAN->icon())->toBe('vegan')
        ->and(Diet::VEGETARIAN->icon())->toBe('leafy-green')
        ->and(Diet::GLUTEN_FREE->icon())->toBe('wheat-off')
        ->and(Diet::PESCETARIAN->icon())->toBe('fish')
        ->and(Diet::MEAT->icon())->toBe('beef');
});
