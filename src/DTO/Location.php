<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

/**
 *The location of a character
 */
readonly class Location implements FromArray
{
    public function __construct(
        public int $solar_system_id,
        public ?int $station_id = null,
        public ?int $structure_id = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            solar_system_id: $data['solar_system_id'],
            station_id: $data['station_id'] ?? null,
            structure_id: $data['structure_id'] ?? null,
        );
    }
}
