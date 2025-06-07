<?php

declare(strict_types=1);

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Services\RecipeService
 */
final class RecipeService extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \App\Services\RecipeService::class;
    }
}
