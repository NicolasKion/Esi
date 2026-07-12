<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class MarketPrice extends Dto
{
    public function __construct(
        public int $type_id,
        public ?float $adjusted_price,
        public ?float $average_price,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            type_id: $data->integer('type_id', 0),
            adjusted_price: $data->float('adjusted_price'),
            average_price: $data->float('average_price'),
        );
    }
}
