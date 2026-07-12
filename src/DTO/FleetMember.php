<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class FleetMember extends Dto
{
    public function __construct(
        public int $character_id,
        public int $ship_type_id,
        public int $solar_system_id,
        public int $squad_id,
        public int $wing_id,
        public string $role,
        public string $role_name,
        public string $join_time,
        public ?int $station_id,
        public bool $takes_fleet_warp,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            character_id: $data->integer('character_id', 0),
            ship_type_id: $data->integer('ship_type_id', 0),
            solar_system_id: $data->integer('solar_system_id', 0),
            squad_id: $data->integer('squad_id', 0),
            wing_id: $data->integer('wing_id', 0),
            role: $data->string('role', ''),
            role_name: $data->string('role_name', ''),
            join_time: $data->string('join_time', ''),
            station_id: $data->integer('station_id'),
            takes_fleet_warp: $data->boolean('takes_fleet_warp', false),
        );
    }
}
