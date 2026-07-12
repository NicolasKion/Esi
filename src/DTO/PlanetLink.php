<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class PlanetLink extends Dto
{
    public function __construct(
        public int $destination_pin_id,
        public int $link_level,
        public int $source_pin_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            destination_pin_id: $data->integer('destination_pin_id', 0),
            link_level: $data->integer('link_level', 0),
            source_pin_id: $data->integer('source_pin_id', 0),
        );
    }
}
