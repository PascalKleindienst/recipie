<?php

declare(strict_types=1);

namespace App\Enums;

enum Diet: string
{
    case VEGAN = 'vegan';
    case VEGETARIAN = 'vegetarian';
    case GLUTEN_FREE = 'gluten-free';
    case PESCETARIAN = 'pescetarian';
    case MEAT = 'meat';

    public function label(): string
    {
        return match ($this) {
            self::VEGAN => __('recipe.diets.vegan'),
            self::VEGETARIAN => __('recipe.diets.vegetarian'),
            self::GLUTEN_FREE => __('recipe.diets.gluten-free'),
            self::PESCETARIAN => __('recipe.diets.pescetarian'),
            self::MEAT => __('recipe.diets.meat'),
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::VEGAN => 'vegan',
            self::VEGETARIAN => 'leafy-green',
            self::GLUTEN_FREE => 'wheat-off',
            self::PESCETARIAN => 'fish',
            self::MEAT => 'beef',
        };
    }
}
