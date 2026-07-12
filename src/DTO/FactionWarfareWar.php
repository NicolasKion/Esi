<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class FactionWarfareWar extends Dto
{
    public function __construct(
        public int $against_id,
        public int $faction_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            against_id: $data->integer('against_id', 0),
            faction_id: $data->integer('faction_id', 0),
        );
    }
}
