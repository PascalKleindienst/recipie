<?php

declare(strict_types=1);

namespace App\Casts;

use App\ValueObjects\Nutrient;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use JsonException;

/**
 * @implements CastsAttributes<Nutrient[]|null, string>
 */
final class NutrientCast implements CastsAttributes
{
    /**
     * @throws JsonException
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (empty($value)) {
            return null;
        }

        $nutrients = json_decode($value, true, flags: JSON_THROW_ON_ERROR);
        $data = [];

        foreach ($nutrients as $nutrient => $amount) {
            if ($amount === null || $amount === '') {
                continue;
            }

            $data[] = new Nutrient([
                'type' => $nutrient,
                'amount' => $amount,
            ]);
        }

        return $data;
    }

    /**
     * @throws JsonException
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        return json_encode($value, JSON_THROW_ON_ERROR);
    }
}
