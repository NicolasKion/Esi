<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 *The location of a character
 */
readonly class Location extends Dto
{
    public function __construct(
        public int $solar_system_id,
        public ?int $station_id = null,
        public ?int $structure_id = null,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            solar_system_id: $data->integer('solar_system_id', 0),
            station_id: $data->integer('station_id'),
            structure_id: $data->integer('structure_id'),
        );
    }
}
