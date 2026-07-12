<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class FactionWarfareFactionStats extends Dto
{
    public function __construct(
        public int $faction_id,
        public FactionWarfareStatsSummary $kills,
        public int $pilots,
        public int $systems_controlled,
        public FactionWarfareStatsSummary $victory_points,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            faction_id: $data->integer('faction_id', 0),
            kills: FactionWarfareStatsSummary::fromData($data->object('kills')),
            pilots: $data->integer('pilots', 0),
            systems_controlled: $data->integer('systems_controlled', 0),
            victory_points: FactionWarfareStatsSummary::fromData($data->object('victory_points')),
        );
    }
}
