<?php

declare(strict_types=1);

use App\ValueObjects\Nutrients;

it('can be created with constructor', function (): void {
    // Arrange & Act
    $nutrients = new Nutrients(
        calories: 200.0,
        carbohydrates: 30.0,
        fat: 10.0,
        protein: 15.0,
        fiber: 5.0,
        sugar: 8.0
    );

    // Assert
    expect($nutrients->calories)->toBe(200.0)
        ->and($nutrients->carbohydrates)->toBe(30.0)
        ->and($nutrients->fat)->toBe(10.0)
        ->and($nutrients->protein)->toBe(15.0)
        ->and($nutrients->fiber)->toBe(5.0)
        ->and($nutrients->sugar)->toBe(8.0);
});

it('can be created from an array', function (): void {
    // Arrange
    $data = [
        'calories' => '200',
        'carbohydrates' => '30',
        'fat' => '10',
        'protein' => '15',
        'fiber' => '5',
        'sugar' => '8',
    ];

    // Act
    $nutrients = Nutrients::from($data);

    // Assert
    expect($nutrients->calories)->toBe(200.0)
        ->and($nutrients->carbohydrates)->toBe(30.0)
        ->and($nutrients->fat)->toBe(10.0)
        ->and($nutrients->protein)->toBe(15.0)
        ->and($nutrients->fiber)->toBe(5.0)
        ->and($nutrients->sugar)->toBe(8.0);
});

it('handles empty values when creating from array', function (): void {
    // Arrange
    $data = [
        'calories' => '200',
        'carbohydrates' => '',
        'fat' => null,
        'protein' => '15',
        'fiber' => 0,
        'sugar' => '',
    ];

    // Act
    $nutrients = Nutrients::from($data);

    // Assert
    expect($nutrients->calories)->toBe(200.0)
        ->and($nutrients->carbohydrates)->toBeNull()
        ->and($nutrients->fat)->toBeNull()
        ->and($nutrients->protein)->toBe(15.0)
        ->and($nutrients->fiber)->toBeNull()
        ->and($nutrients->sugar)->toBeNull();
});

it('can be converted to an array', function (): void {
    // Arrange
    $nutrients = new Nutrients(
        calories: 200.0,
        carbohydrates: 30.0,
        fat: 10.0,
        protein: 15.0,
        fiber: 5.0,
        sugar: 8.0
    );

    // Act
    $array = $nutrients->toArray();

    // Assert
    expect($array)->toBe([
        'calories' => 200.0,
        'carbohydrates' => 30.0,
        'fat' => 10.0,
        'protein' => 15.0,
        'fiber' => 5.0,
        'sugar' => 8.0,
    ]);
});
