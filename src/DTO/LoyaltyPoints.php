<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class LoyaltyPoints extends Dto
{
    public function __construct(
        public int $corporation_id,
        public int $loyalty_points,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            corporation_id: $data->integer('corporation_id', 0),
            loyalty_points: $data->integer('loyalty_points', 0),
        );
    }
}
