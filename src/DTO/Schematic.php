<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Schematic extends Dto
{
    public function __construct(
        public string $schematic_name,
        public int $cycle_time,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            schematic_name: $data->string('schematic_name', ''),
            cycle_time: $data->integer('cycle_time', 0),
        );
    }
}
