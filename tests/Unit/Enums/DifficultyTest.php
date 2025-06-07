<?php

declare(strict_types=1);

use App\Enums\Difficulty;

it('has the expected cases', function (): void {
    // Assert
    expect(Difficulty::cases())->toHaveCount(3)
        ->and(Difficulty::EASY->value)->toBe('easy')
        ->and(Difficulty::MEDIUM->value)->toBe('medium')
        ->and(Difficulty::HARD->value)->toBe('hard');
});

it('can be created from string value', function (): void {
    // Act & Assert
    expect(Difficulty::from('easy'))->toBe(Difficulty::EASY)
        ->and(Difficulty::from('medium'))->toBe(Difficulty::MEDIUM)
        ->and(Difficulty::from('hard'))->toBe(Difficulty::HARD);
});

it('provides a label', function (): void {
    // Arrange
    $difficulty = Difficulty::EASY;

    // Act
    $label = $difficulty->label();

    // Assert
    // Since the label uses translation, we can't test the exact string
    // but we can test that it returns a string
    expect($label)->toBeString();
});
