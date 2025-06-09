<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\NutrientCast;
use App\Enums\Diet;
use App\Enums\Difficulty;
use App\ValueObjects\Nutrient;
use Database\Factories\RecipeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $preptime
 * @property int $cooktime
 * @property string|null $source
 * @property float|null $servings
 * @property Difficulty $difficulty
 * @property string|null $cuisine
 * @property array<array-key, mixed>|null $tags
 * @property Diet|null $diet
 * @property Nutrient[]|null $nutrients
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, RecipeIngredient> $ingredients
 * @property-read int|null $ingredients_count
 * @property-read Collection<int, RecipeInstruction> $instructions
 * @property-read int|null $instructions_count
 * @property-read User $user
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 *
 * @method static RecipeFactory factory($count = null, $state = [])
 * @method static Builder<static>|Recipe newModelQuery()
 * @method static Builder<static>|Recipe newQuery()
 * @method static Builder<static>|Recipe query()
 * @method static Builder<static>|Recipe whereCooktime($value)
 * @method static Builder<static>|Recipe whereCreatedAt($value)
 * @method static Builder<static>|Recipe whereCuisine($value)
 * @method static Builder<static>|Recipe whereDescription($value)
 * @method static Builder<static>|Recipe whereDiet($value)
 * @method static Builder<static>|Recipe whereDifficulty($value)
 * @method static Builder<static>|Recipe whereId($value)
 * @method static Builder<static>|Recipe whereNutrients($value)
 * @method static Builder<static>|Recipe wherePreptime($value)
 * @method static Builder<static>|Recipe whereServings($value)
 * @method static Builder<static>|Recipe whereSource($value)
 * @method static Builder<static>|Recipe whereTags($value)
 * @method static Builder<static>|Recipe whereTitle($value)
 * @method static Builder<static>|Recipe whereUpdatedAt($value)
 * @method static Builder<static>|Recipe whereUserId($value)
 *
 * @mixin Eloquent
 */
final class Recipe extends Model implements HasMedia
{
    /** @use HasFactory<RecipeFactory> */
    use HasFactory;

    use HasRelationships;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'preptime',
        'cooktime',
        'source',
        'servings',
        'difficulty',
        'diet',
        'nutrients',
        'tags',
        'cuisine',
        'user_id',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('recipes')
            ->singleFile()
            ->withResponsiveImages();
    }

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
            'nutrients' => NutrientCast::class,
        ];
    }
}
