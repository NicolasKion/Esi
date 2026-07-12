<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class SovereigntyHubReagent extends Dto
{
    public function __construct(
        public int $type_id,
        public int $amount,
        public int $burning_per_hour,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            type_id: $data->integer('type_id', 0),
            amount: $data->integer('amount', 0),
            burning_per_hour: $data->integer('burning_per_hour', 0),
        );
    }
}
