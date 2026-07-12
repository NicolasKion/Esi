<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class FactionWarfareCharacterLeaderboardEntry extends Dto
{
    public function __construct(
        public int $amount,
        public int $character_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            amount: $data->integer('amount', 0),
            character_id: $data->integer('character_id', 0),
        );
    }
}
