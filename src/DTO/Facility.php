<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Facility extends Dto
{
    public function __construct(
        public int $facility_id,
        public int $system_id,
        public int $type_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            facility_id: $data->integer('facility_id', 0),
            system_id: $data->integer('system_id', 0),
            type_id: $data->integer('type_id', 0),
        );
    }
}
