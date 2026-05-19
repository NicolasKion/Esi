<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class RaidableSkyhook implements FromArray
{
    public function __construct(
        public int $planet_id,
        public int $solar_system_id,
        public SkyhookTheftVulnerability $theft_vulnerability,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            planet_id: $data['planet_id'],
            solar_system_id: $data['solar_system_id'],
            theft_vulnerability: SkyhookTheftVulnerability::fromArray($data['theft_vulnerability']),
        );
    }
}
