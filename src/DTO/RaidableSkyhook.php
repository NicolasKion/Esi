<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class RaidableSkyhook extends Dto
{
    public function __construct(
        public int $planet_id,
        public int $solar_system_id,
        public SkyhookTheftVulnerability $theft_vulnerability,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            planet_id: $data->integer('planet_id', 0),
            solar_system_id: $data->integer('solar_system_id', 0),
            theft_vulnerability: SkyhookTheftVulnerability::fromData($data->object('theft_vulnerability')),
        );
    }
}
