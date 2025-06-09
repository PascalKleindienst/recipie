<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\RecipeInstructionFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $position
 * @property string $content
 * @property string|null $image
 * @property int $recipe_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Recipe $recipe
 *
 * @method static RecipeInstructionFactory factory($count = null, $state = [])
 * @method static Builder<static>|RecipeInstruction newModelQuery()
 * @method static Builder<static>|RecipeInstruction newQuery()
 * @method static Builder<static>|RecipeInstruction query()
 * @method static Builder<static>|RecipeInstruction whereContent($value)
 * @method static Builder<static>|RecipeInstruction whereCreatedAt($value)
 * @method static Builder<static>|RecipeInstruction whereId($value)
 * @method static Builder<static>|RecipeInstruction whereImage($value)
 * @method static Builder<static>|RecipeInstruction wherePosition($value)
 * @method static Builder<static>|RecipeInstruction whereRecipeId($value)
 * @method static Builder<static>|RecipeInstruction whereUpdatedAt($value)
 *
 * @mixin Eloquent
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
