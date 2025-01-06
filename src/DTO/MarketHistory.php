<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class MarketHistory implements FromArray
{
    public function __construct(
        public float $average,
        public string $date,
        public float $highest,
        public float $lowest,
        public int $order_count,
        public int $volume
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            average: $data['average'],
            date: $data['date'],
            highest: $data['highest'],
            lowest: $data['lowest'],
            order_count: $data['order_count'],
            volume: $data['volume']
        );
    }
}
