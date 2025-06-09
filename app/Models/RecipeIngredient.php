<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\RecipeIngredientFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property float|null $amount
 * @property string|null $unit
 * @property int $recipe_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Recipe $recipe
 *
 * @method static RecipeIngredientFactory factory($count = null, $state = [])
 * @method static Builder<static>|RecipeIngredient newModelQuery()
 * @method static Builder<static>|RecipeIngredient newQuery()
 * @method static Builder<static>|RecipeIngredient query()
 * @method static Builder<static>|RecipeIngredient whereAmount($value)
 * @method static Builder<static>|RecipeIngredient whereCreatedAt($value)
 * @method static Builder<static>|RecipeIngredient whereId($value)
 * @method static Builder<static>|RecipeIngredient whereName($value)
 * @method static Builder<static>|RecipeIngredient whereRecipeId($value)
 * @method static Builder<static>|RecipeIngredient whereUnit($value)
 * @method static Builder<static>|RecipeIngredient whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
final class RecipeIngredient extends Model
{
    /** @use HasFactory<RecipeIngredientFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<Recipe, $this>
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
}
