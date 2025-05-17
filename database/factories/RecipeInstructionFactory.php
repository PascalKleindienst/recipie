<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\RecipeInstruction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class RecipeInstructionFactory extends Factory
{
    protected $model = RecipeInstruction::class;

    public function definition(): array
    {
        return [
            'position' => $this->faker->randomNumber(),
            'content' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'recipe_id' => Recipe::factory(),
        ];
    }
}
