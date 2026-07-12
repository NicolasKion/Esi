<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class FleetInfo extends Dto
{
    public function __construct(
        public int $fleet_id,
        public int $fleet_boss_id,
        public string $role,
        public int $squad_id,
        public int $wing_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            fleet_id: $data->integer('fleet_id', 0),
            fleet_boss_id: $data->integer('fleet_boss_id', 0),
            role: $data->string('role', ''),
            squad_id: $data->integer('squad_id', 0),
            wing_id: $data->integer('wing_id', 0),
        );
    }
}
