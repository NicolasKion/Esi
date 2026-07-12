<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class IndustryFacility extends Dto
{
    public function __construct(
        public int $facility_id,
        public int $owner_id,
        public int $region_id,
        public int $solar_system_id,
        public ?float $tax,
        public int $type_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            facility_id: $data->integer('facility_id', 0),
            owner_id: $data->integer('owner_id', 0),
            region_id: $data->integer('region_id', 0),
            solar_system_id: $data->integer('solar_system_id', 0),
            tax: $data->float('tax'),
            type_id: $data->integer('type_id', 0),
        );
    }
}
