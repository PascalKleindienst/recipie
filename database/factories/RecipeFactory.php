<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Diet;
use App\Enums\Difficulty;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Recipe>
 */
final class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->words(asText: true),
            'description' => $this->faker->paragraph(),
            'preptime' => $this->faker->randomDigit(),
            'cooktime' => $this->faker->randomDigit(),
            'source' => $this->faker->url(),
            'image' => null,
            'servings' => $this->faker->randomFloat(),
            'difficulty' => $this->faker->randomElement(Difficulty::cases()),
            'diet' => $this->faker->randomElement(Diet::cases()),
            'nutrients' => [
                'calories' => $this->faker->randomNumber(),
                'fat' => $this->faker->randomFloat(),
                'carbs' => $this->faker->randomFloat(),
                'protein' => $this->faker->randomFloat(),
                'fiber' => $this->faker->randomFloat(),
            ],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
