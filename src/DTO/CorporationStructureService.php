<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class CorporationStructureService implements FromArray
{
    public function __construct(
        public string $name,
        public string $state,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            state: $data['state'],
        );
    }
}
