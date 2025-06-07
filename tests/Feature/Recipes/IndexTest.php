<?php

declare(strict_types=1);

use App\Enums\Diet;
use App\Enums\Difficulty;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('recipes index page can be rendered', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('recipes.index'))
        ->assertStatus(200);
});

test('recipes are displayed on the index page', function (): void {
    $user = User::factory()->create();
    $recipes = Recipe::factory()->count(3)->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user)
        ->get(route('recipes.index'))
        ->assertSee($recipes[0]->title)
        ->assertSee($recipes[1]->title)
        ->assertSee($recipes[2]->title);
});

test('recipes can be filtered by diet', function (): void {
    $user = User::factory()->create();

    $veganRecipe = Recipe::factory()->create([
        'user_id' => $user->id,
        'diet' => Diet::VEGAN,
        'title' => 'Vegan Recipe',
    ]);

    $meatRecipe = Recipe::factory()->create([
        'user_id' => $user->id,
        'diet' => Diet::MEAT,
        'title' => 'Meat Recipe',
    ]);

    Livewire::test('recipes.index')
        ->set('diet', Diet::VEGAN)
        ->assertSee('Vegan Recipe')
        ->assertDontSee('Meat Recipe');
});

test('recipes can be filtered by difficulty', function (): void {
    $user = User::factory()->create();

    $easyRecipe = Recipe::factory()->create([
        'user_id' => $user->id,
        'difficulty' => Difficulty::EASY,
        'title' => 'Easy Recipe',
    ]);

    $hardRecipe = Recipe::factory()->create([
        'user_id' => $user->id,
        'difficulty' => Difficulty::HARD,
        'title' => 'Hard Recipe',
    ]);

    Livewire::test('recipes.index')
        ->set('difficulty', Difficulty::EASY)
        ->assertSee('Easy Recipe')
        ->assertDontSee('Hard Recipe');
});

test('recipes can be paginated', function (): void {
    $user = User::factory()->create();

    // Create 30 recipes (more than the default 25 per page)
    $recipes = Recipe::factory()->count(30)->create([
        'user_id' => $user->id,
    ]);

    // Test that we can see the first page of recipes
    $firstPageRecipe = $recipes[0];
    $secondPageRecipe = $recipes[25]; // This should be on the second page

    $this->actingAs($user)
        ->get(route('recipes.index'))
        ->assertSee($firstPageRecipe->title)
        ->assertDontSee($secondPageRecipe->title);
});
