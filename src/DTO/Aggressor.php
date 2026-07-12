<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Aggressor extends Dto
{
    public function __construct(
        public ?int $alliance_id,
        public ?int $corporation_id,
        public float $isk_destroyed,
        public int $ships_killed,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            alliance_id: $data->integer('alliance_id'),
            corporation_id: $data->integer('corporation_id'),
            isk_destroyed: $data->float('isk_destroyed', 0.0),
            ships_killed: $data->integer('ships_killed', 0),
        );
    }
}
