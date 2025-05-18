<?php

declare(strict_types=1);

namespace App\Enums;

enum Difficulty: string
{
    case EASY = 'easy';
    case MEDIUM = 'medium';
    case HARD = 'hard';

    public function label(): string
    {
        return match ($this) {
            self::EASY => __('recipe.difficulties.easy'),
            self::MEDIUM => __('recipe.difficulties.medium'),
            self::HARD => __('recipe.difficulties.hard'),
        };
    }
}
