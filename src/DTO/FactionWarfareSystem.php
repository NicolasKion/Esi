<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class FactionWarfareSystem extends Dto
{
    public function __construct(
        public string $contested,
        public int $occupier_faction_id,
        public int $owner_faction_id,
        public int $solar_system_id,
        public int $victory_points,
        public int $victory_points_threshold,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            contested: $data->string('contested', ''),
            occupier_faction_id: $data->integer('occupier_faction_id', 0),
            owner_faction_id: $data->integer('owner_faction_id', 0),
            solar_system_id: $data->integer('solar_system_id', 0),
            victory_points: $data->integer('victory_points', 0),
            victory_points_threshold: $data->integer('victory_points_threshold', 0),
        );
    }
}
