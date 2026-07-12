<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CharacterFactionWarfareStats extends Dto
{
    public function __construct(
        public ?int $current_rank,
        public ?string $enlisted_on,
        public ?int $faction_id,
        public ?int $highest_rank,
        public FactionWarfareStatsSummary $kills,
        public FactionWarfareStatsSummary $victory_points,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            current_rank: $data->integer('current_rank'),
            enlisted_on: $data->string('enlisted_on'),
            faction_id: $data->integer('faction_id'),
            highest_rank: $data->integer('highest_rank'),
            kills: FactionWarfareStatsSummary::fromData($data->object('kills')),
            victory_points: FactionWarfareStatsSummary::fromData($data->object('victory_points')),
        );
    }
}
