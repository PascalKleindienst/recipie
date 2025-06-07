<?php

declare(strict_types=1);

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Support\Carbon;

it('can be created using the factory', function (): void {
    // Act
    $user = User::factory()->create();

    // Assert
    expect($user)->toBeInstanceOf(User::class)
        ->and($user->exists)->toBeTrue();
});

it('has fillable attributes', function (): void {
    // Arrange
    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
    ];

    // Act
    $user = new User($data);
    $user->save();

    // Assert
    expect($user->name)->toBe('John Doe')
        ->and($user->email)->toBe('john@example.com');
});

it('hides sensitive attributes', function (): void {
    // Arrange
    $user = User::factory()->create([
        'password' => 'secret-password',
        'remember_token' => 'token123',
        'two_factor_recovery_codes' => 'recovery-codes',
        'two_factor_secret' => 'secret-key',
    ]);

    // Act
    $userArray = $user->toArray();

    // Assert
    expect($userArray)->not->toHaveKey('password')
        ->and($userArray)->not->toHaveKey('remember_token')
        ->and($userArray)->not->toHaveKey('two_factor_recovery_codes')
        ->and($userArray)->not->toHaveKey('two_factor_secret');
});

it('appends profile_photo_url', function (): void {
    // Arrange
    $user = User::factory()->create();

    // Act
    $userArray = $user->toArray();

    // Assert
    expect($userArray)->toHaveKey('profile_photo_url');
});

it('casts email_verified_at to datetime', function (): void {
    // Arrange
    $now = now();
    $user = User::factory()->create([
        'email_verified_at' => $now,
    ]);

    // Act & Assert
    expect($user->email_verified_at)->toBeInstanceOf(Carbon::class)
        ->and($user->email_verified_at->timestamp)->toBe($now->timestamp);
});

it('casts password to hashed', function (): void {
    // Arrange
    $user = new User();
    $user->password = 'password123';

    // Act & Assert
    expect($user->password)->not->toBe('password123')
        ->and(password_verify('password123', $user->password))->toBeTrue();
});

it('has many recipes', function (): void {
    // Arrange
    $user = User::factory()->create();
    $recipes = Recipe::factory()->count(3)->create([
        'user_id' => $user->id,
    ]);

    // Act & Assert
    expect($user->recipes)->toHaveCount(3)
        ->and($user->recipes->first())->toBeInstanceOf(Recipe::class);
});

it('can generate initials from name', function (): void {
    // Arrange
    $user = User::factory()->create([
        'name' => 'John Doe',
    ]);

    // Act
    $initials = $user->initials();

    // Assert
    expect($initials)->toBe('JD');
});

it('can generate initials from single name', function (): void {
    // Arrange
    $user = User::factory()->create([
        'name' => 'Madonna',
    ]);

    // Act
    $initials = $user->initials();

    // Assert
    expect($initials)->toBe('M');
});

it('can generate initials from multiple names', function (): void {
    // Arrange
    $user = User::factory()->create([
        'name' => 'John James Doe Smith',
    ]);

    // Act
    $initials = $user->initials();

    // Assert
    expect($initials)->toBe('JJDS');
});
