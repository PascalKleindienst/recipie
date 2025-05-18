<?php

declare(strict_types=1);

namespace App\Enums;

enum NutrientType: string
{
    case CALORIES = 'calories';
    case CARBS = 'carbs';
    case FAT = 'fat';
    case PROTEIN = 'protein';
    case FIBER = 'fiber';
    case SUGAR = 'sugar';

    public function label(): string
    {
        return match ($this) {
            self::CALORIES => __('recipe.nutrients.calories'),
            self::CARBS => __('recipe.nutrients.carbohydrates'),
            self::FAT => __('recipe.nutrients.fat'),
            self::PROTEIN => __('recipe.nutrients.protein'),
            self::FIBER => __('recipe.nutrients.fiber'),
            self::SUGAR => __('recipe.nutrients.sugar'),
        };
    }
}
