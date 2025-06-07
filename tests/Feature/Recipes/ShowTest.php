<?php

declare(strict_types=1);

use App\Enums\Difficulty;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Models\RecipeInstruction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('recipe show page can be rendered', function (): void {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user)
        ->get(route('recipes.show', $recipe))
        ->assertStatus(200);
});

test('recipe details are displayed on the show page', function (): void {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create([
        'user_id' => $user->id,
        'title' => 'Test Recipe Title',
        'description' => 'Test Recipe Description',
        'preptime' => 15,
        'cooktime' => 30,
        'servings' => 4,
        'difficulty' => Difficulty::MEDIUM,
        'cuisine' => 'Italian',
    ]);

    $this->actingAs($user)
        ->get(route('recipes.show', $recipe))
        ->assertSee('Test Recipe Title')
        ->assertSee('Test Recipe Description')
        ->assertSee('15min')
        ->assertSee('30min')
        ->assertSee('4')
        ->assertSee('Italian');
});

test('recipe ingredients are displayed on the show page', function (): void {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create([
        'user_id' => $user->id,
    ]);

    $ingredient1 = RecipeIngredient::factory()->create([
        'recipe_id' => $recipe->id,
        'name' => 'Test Ingredient 1',
        'amount' => 2,
        'unit' => 'cups',
    ]);

    $ingredient2 = RecipeIngredient::factory()->create([
        'recipe_id' => $recipe->id,
        'name' => 'Test Ingredient 2',
        'amount' => 1,
        'unit' => 'tbsp',
    ]);

    $this->actingAs($user)
        ->get(route('recipes.show', $recipe))
        ->assertSee('Test Ingredient 1')
        ->assertSee('2 cups')
        ->assertSee('Test Ingredient 2')
        ->assertSee('1 tbsp');
});

test('recipe instructions are displayed on the show page', function (): void {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create([
        'user_id' => $user->id,
    ]);

    $instruction1 = RecipeInstruction::factory()->create([
        'recipe_id' => $recipe->id,
        'position' => 1,
        'content' => 'Test Instruction 1',
    ]);

    $instruction2 = RecipeInstruction::factory()->create([
        'recipe_id' => $recipe->id,
        'position' => 2,
        'content' => 'Test Instruction 2',
    ]);

    $this->actingAs($user)
        ->get(route('recipes.show', $recipe))
        ->assertSee('Test Instruction 1')
        ->assertSee('Test Instruction 2');
});

test('pdf download button is displayed on the show page', function (): void {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user)
        ->get(route('recipes.show', $recipe))
        ->assertSee('wire:click="downloadPdf"', false);
});

test('pdf can be downloaded', function (): void {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create([
        'user_id' => $user->id,
        'title' => 'Test Recipe for PDF',
    ]);

    Livewire::test('recipes.show', ['recipe' => $recipe])
        ->call('downloadPdf')
        ->assertFileDownloaded('test-recipe-for-pdf.pdf');
});
