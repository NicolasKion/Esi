<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class FactionWarfareLeaderboardEntry extends Dto
{
    public function __construct(
        public int $amount,
        public int $faction_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            amount: $data->integer('amount', 0),
            faction_id: $data->integer('faction_id', 0),
        );
    }
}
