<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\RecipeInstructionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $position
 * @property string $content
 * @property string|null $image
 * @property int $recipe_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Recipe $recipe
 *
 * @method static \Database\Factories\RecipeInstructionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecipeInstruction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecipeInstruction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecipeInstruction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecipeInstruction whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecipeInstruction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecipeInstruction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecipeInstruction whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecipeInstruction wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecipeInstruction whereRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RecipeInstruction whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class RecipeInstruction extends Model
{
    /** @use HasFactory<RecipeInstructionFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<Recipe, $this>
     */
    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
}
