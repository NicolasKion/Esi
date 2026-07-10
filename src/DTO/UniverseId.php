<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class UniverseId implements FromArray
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
        );
    }
}
