<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class FactionWarfareCorporationLeaderboardEntry extends Dto
{
    public function __construct(
        public int $amount,
        public int $corporation_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            amount: $data->integer('amount', 0),
            corporation_id: $data->integer('corporation_id', 0),
        );
    }
}
