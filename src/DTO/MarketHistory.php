<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class MarketHistory extends Dto
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

    public static function fromData(Data $data): self
    {
        return new self(
            average: $data->float('average', 0.0),
            date: $data->string('date', ''),
            highest: $data->float('highest', 0.0),
            lowest: $data->float('lowest', 0.0),
            order_count: $data->integer('order_count', 0),
            volume: $data->integer('volume', 0)
        );
    }
}
