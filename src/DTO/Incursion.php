<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Incursion extends Dto
{
    /**
     * @param  array<int, int>  $infested_solar_systems
     */
    public function __construct(
        public int $constellation_id,
        public int $faction_id,
        public bool $has_boss,
        public array $infested_solar_systems,
        public float $influence,
        public int $staging_solar_system_id,
        public string $state,
        public string $type,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            constellation_id: $data->integer('constellation_id', 0),
            faction_id: $data->integer('faction_id', 0),
            has_boss: $data->boolean('has_boss', false),
            infested_solar_systems: $data->integers('infested_solar_systems'),
            influence: $data->float('influence', 0.0),
            staging_solar_system_id: $data->integer('staging_solar_system_id', 0),
            state: $data->string('state', ''),
            type: $data->string('type', ''),
        );
    }
}
