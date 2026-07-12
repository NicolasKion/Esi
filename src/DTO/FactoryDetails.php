<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class FactoryDetails extends Dto
{
    public function __construct(
        public int $schematic_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            schematic_id: $data->integer('schematic_id', 0),
        );
    }
}
