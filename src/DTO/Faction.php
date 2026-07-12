<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Faction extends Dto
{
    public function __construct(
        public int $faction_id,
        public string $name,
        public string $description,
        public float $size_factor,
        public int $station_count,
        public int $station_system_count,
        public bool $is_unique,
        public ?int $corporation_id,
        public ?int $militia_corporation_id,
        public ?int $solar_system_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            faction_id: $data->integer('faction_id', 0),
            name: $data->string('name', ''),
            description: $data->string('description', ''),
            size_factor: $data->float('size_factor', 0.0),
            station_count: $data->integer('station_count', 0),
            station_system_count: $data->integer('station_system_count', 0),
            is_unique: $data->boolean('is_unique', false),
            corporation_id: $data->integer('corporation_id'),
            militia_corporation_id: $data->integer('militia_corporation_id'),
            solar_system_id: $data->integer('solar_system_id'),
        );
    }
}
