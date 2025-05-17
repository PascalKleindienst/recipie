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
            self::VEGAN => __('Vegan'),
            self::VEGETARIAN => __('Vegetarian'),
            self::GLUTEN_FREE => __('Gluten-free'),
            self::PESCETARIAN => __('Pescetarian'),
            self::MEAT => __('Meat'),
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

    public function color(): string
    {
        return match ($this) {
            self::VEGAN => 'green',
            self::VEGETARIAN => 'green',
            self::GLUTEN_FREE => 'green',
            self::PESCETARIAN => 'green',
            self::MEAT => 'green',
        };
    }
}
