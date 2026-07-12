<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class PlanetColony extends Dto
{
    public function __construct(
        public string $last_update,
        public int $num_pins,
        public int $owner_id,
        public int $planet_id,
        public string $planet_type,
        public int $solar_system_id,
        public int $upgrade_level,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            last_update: $data->string('last_update', ''),
            num_pins: $data->integer('num_pins', 0),
            owner_id: $data->integer('owner_id', 0),
            planet_id: $data->integer('planet_id', 0),
            planet_type: $data->string('planet_type', ''),
            solar_system_id: $data->integer('solar_system_id', 0),
            upgrade_level: $data->integer('upgrade_level', 0),
        );
    }
}
