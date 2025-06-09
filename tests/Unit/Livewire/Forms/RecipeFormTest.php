<?php

declare(strict_types=1);

use App\Enums\Diet;
use App\Enums\Difficulty;
use App\Livewire\Forms\RecipeForm;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

// beforeEach(function (): void {
//     Storage::fake('public');
//     $this->form = app(RecipeForm::class);
// });
//
// it('has validation attributes', function (): void {
//     // Act
//     $attributes = $this->form->validationAttributes();
//
//     // Assert
//     expect($attributes)->toBeArray()
//         ->and($attributes)->toHaveKey('title')
//         ->and($attributes)->toHaveKey('ingredients.*.name')
//         ->and($attributes)->toHaveKey('ingredients.*.amount');
// });
//
// it('has validation rules', function (): void {
//     // Act
//     $rules = $this->form->rules();
//
//     // Assert
//     expect($rules)->toBeArray()
//         ->and($rules)->toHaveKey('title')
//         ->and($rules['title'])->toContain('required')
//         ->and($rules)->toHaveKey('preptime')
//         ->and($rules['preptime'])->toContain('required')
//         ->and($rules['preptime'])->toContain('integer')
//         ->and($rules['preptime'])->toContain('min:0')
//         ->and($rules)->toHaveKey('ingredients')
//         ->and($rules['ingredients'])->toContain('required')
//         ->and($rules['ingredients'])->toContain('min:1')
//         ->and($rules)->toHaveKey('instructions')
//         ->and($rules['instructions'])->toContain('required')
//         ->and($rules['instructions'])->toContain('min:1');
// });
//
// it('can store a recipe', function (): void {
//     // Arrange
//     $user = User::factory()->create();
//     Auth::login($user);
//
//     $this->form->title = 'Test Recipe';
//     $this->form->description = 'A test recipe description';
//     $this->form->preptime = 15;
//     $this->form->cooktime = 30;
//     $this->form->source = 'https://example.com/recipe';
//     $this->form->servings = 4;
//     $this->form->cuisine = 'Italian';
//     $this->form->difficulty = Difficulty::MEDIUM;
//     $this->form->diet = Diet::VEGETARIAN;
//     $this->form->tags = ['italian', 'pasta'];
//     $this->form->nutrients = [
//         'calories' => 500,
//         'protein' => 20,
//     ];
//
//     // Mock the image upload
//     $file = UploadedFile::fake()->image('recipe.jpg');
//     $tempFile = TemporaryUploadedFile::createFromLivewire('photos/recipe.jpg', $file->getPathname());
//     $this->form->image = $tempFile;
//
//     $this->form->ingredients = [
//         ['name' => 'Flour', 'amount' => 2, 'unit' => 'cups'],
//         ['name' => 'Water', 'amount' => 1, 'unit' => 'cup'],
//     ];
//
//     $this->form->instructions = [
//         ['position' => 0, 'content' => 'Mix flour and water'],
//         ['position' => 0, 'content' => 'Knead the dough'],
//     ];
//
//     // Act
//     $this->form->store();
//
//     // Assert
//     $recipe = Recipe::latest('id')->first();
//
//     expect($recipe)->not->toBeNull()
//         ->and($recipe->title)->toBe('Test Recipe')
//         ->and($recipe->description)->toBe('A test recipe description')
//         ->and($recipe->preptime)->toBe(15)
//         ->and($recipe->cooktime)->toBe(30)
//         ->and($recipe->source)->toBe('https://example.com/recipe')
//         ->and($recipe->servings)->toBe(4)
//         ->and($recipe->cuisine)->toBe('Italian')
//         ->and($recipe->difficulty)->toBe(Difficulty::MEDIUM)
//         ->and($recipe->diet)->toBe(Diet::VEGETARIAN)
//         ->and($recipe->tags)->toBe(['italian', 'pasta'])
//         ->and($recipe->user_id)->toBe($user->id)
//         ->and($recipe->image)->not->toBeNull()
//         ->and(Storage::disk('public')->exists('recipes/' . basename($recipe->image)))->toBeTrue()
//         ->and($recipe->ingredients)->toHaveCount(2)
//         ->and($recipe->ingredients[0]->name)->toBe('Flour')
//         ->and($recipe->ingredients[1]->name)->toBe('Water')
//         ->and($recipe->instructions)->toHaveCount(2)
//         ->and($recipe->instructions[0]->position)->toBe(1)
//         ->and($recipe->instructions[0]->content)->toBe('Mix flour and water')
//         ->and($recipe->instructions[1]->position)->toBe(2)
//         ->and($recipe->instructions[1]->content)->toBe('Knead the dough');
// });
//
// it('updates instruction positions when storing', function (): void {
//     // Arrange
//     $user = User::factory()->create();
//     Auth::login($user);
//
//     $this->form->title = 'Test Recipe';
//     $this->form->preptime = 15;
//     $this->form->cooktime = 30;
//     $this->form->difficulty = Difficulty::EASY;
//     $this->form->diet = Diet::VEGAN;
//     $this->form->source = '';
//     $this->form->cuisine = '';
//
//     $this->form->ingredients = [
//         ['name' => 'Ingredient', 'amount' => null, 'unit' => null],
//     ];
//
//     $this->form->instructions = [
//         ['position' => 0, 'content' => 'First instruction'],
//         ['position' => 0, 'content' => 'Second instruction'],
//         ['position' => 0, 'content' => 'Third instruction'],
//     ];
//
//     // Act
//     $this->form->store();
//
//     // Assert
//     $recipe = Recipe::latest('id')->first();
//
//     expect($recipe->instructions)->toHaveCount(3)
//         ->and($recipe->instructions[0]->position)->toBe(1)
//         ->and($recipe->instructions[1]->position)->toBe(2)
//         ->and($recipe->instructions[2]->position)->toBe(3);
// });
