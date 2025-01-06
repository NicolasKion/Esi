<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class DogmaItemAttribute implements FromArray
{
    public function __construct(
        public int $attribute_id,
        public float $value
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['attribute_id'],
            $data['value']
        );
    }
}
