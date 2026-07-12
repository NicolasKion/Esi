<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CorporationFactionWarfareStats extends Dto
{
    public function __construct(
        public ?string $enlisted_on,
        public ?int $faction_id,
        public FactionWarfareStatsSummary $kills,
        public ?int $pilots,
        public FactionWarfareStatsSummary $victory_points,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            enlisted_on: $data->string('enlisted_on'),
            faction_id: $data->integer('faction_id'),
            kills: FactionWarfareStatsSummary::fromData($data->object('kills')),
            pilots: $data->integer('pilots'),
            victory_points: FactionWarfareStatsSummary::fromData($data->object('victory_points')),
        );
    }
}
