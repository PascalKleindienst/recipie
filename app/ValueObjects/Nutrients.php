<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<'calories'|'carbohydrates'|'fat'|'protein'|'fiber'|'sugar', float|null>
 */
final readonly class Nutrients implements Arrayable
{
    public function __construct(
        public ?float $calories,
        public ?float $carbohydrates,
        public ?float $fat,
        public ?float $protein,
        public ?float $fiber,
        public ?float $sugar,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function from(array $data): self
    {
        return new self(
            calories: empty($data['calories']) ? null : (float) $data['calories'],
            carbohydrates: empty($data['carbohydrates']) ? null : (float) $data['carbohydrates'],
            fat: empty($data['fat']) ? null : (float) $data['fat'],
            protein: empty($data['protein']) ? null : (float) $data['protein'],
            fiber: empty($data['fiber']) ? null : (float) $data['fiber'],
            sugar: empty($data['sugar']) ? null : (float) $data['sugar'],
        );
    }

    public function toArray(): array
    {
        return [
            'calories' => $this->calories,
            'carbohydrates' => $this->carbohydrates,
            'fat' => $this->fat,
            'protein' => $this->protein,
            'fiber' => $this->fiber,
            'sugar' => $this->sugar,
        ];
    }
}
