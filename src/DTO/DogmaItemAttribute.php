<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class DogmaItemAttribute extends Dto
{
    public function __construct(
        public int $attribute_id,
        public float $value
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            attribute_id: $data->integer('attribute_id', 0),
            value: $data->float('value', 0.0),
        );
    }
}
