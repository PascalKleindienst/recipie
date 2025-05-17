<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Diet;
use App\Enums\Difficulty;
use Database\Factories\RecipeFactory;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $preptime
 * @property int $cooktime
 * @property string|null $source
 * @property string|null $image
 * @property float|null $servings
 * @property Difficulty $difficulty
 * @property string|null $cuisine
 * @property array<array-key, mixed>|null $tags
 * @property Diet|null $diet
 * @property string|null $nutrients
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RecipeIngredient> $ingredients
 * @property-read int|null $ingredients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RecipeInstruction> $instructions
 * @property-read int|null $instructions_count
 * @property-read \App\Models\User $user
 *
 * @method static \Database\Factories\RecipeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereCooktime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereCuisine($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereDiet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereDifficulty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereNutrients($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe wherePreptime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereServings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereUserId($value)
 *
 * @mixin \Eloquent
 */
final class Recipe extends Model
{
    /** @use HasFactory<RecipeFactory> */
    use HasFactory;

    use HasRelationships;

    protected $fillable = [
        'title',
        'description',
        'preptime',
        'cooktime',
        'source',
        'image',
        'servings',
        'difficulty',
        'diet',
        'nutrients',
        'tags',
        'cuisine',
        'user_id',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<RecipeIngredient, $this>
     */
    public function ingredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    /**
     * @return HasMany<RecipeInstruction, $this>
     */
    public function instructions(): HasMany
    {
        return $this->hasMany(RecipeInstruction::class)->orderBy('position');
    }

    protected function casts(): array
    {
        return [
            'difficulty' => Difficulty::class,
            'diet' => Diet::class,
            'tags' => 'array',
            // 'nutrients' => NutrientCast::class,
        ];
    }
}
