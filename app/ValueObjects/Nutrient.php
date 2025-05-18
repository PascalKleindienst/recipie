<?php

declare(strict_types=1);

namespace App\ValueObjects;

use App\Enums\NutrientType;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Number;
use JsonSerializable;

/**
 * @implements Arrayable<string, float|null>
 */
final readonly class Nutrient implements Arrayable, JsonSerializable
{
    public NutrientType $type;

    public float $amount;

    /**
     * @param  array{type: string, amount: float}  $data
     */
    public function __construct(array $data)
    {
        $this->type = NutrientType::from($data['type']);
        $this->amount = (float) $data['amount'];
    }

    public function formatAmount(): string
    {
        return Number::format($this->amount).' '.match ($this->type) {
            NutrientType::CALORIES => 'kcal',
            default => 'g'
        };
    }

    /**
     * @return array{type: string, amount: float}
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type->value,
            'amount' => $this->amount,
        ];
    }

    /**
     * @return array{type: string, amount: float}
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
