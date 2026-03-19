<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class CorporationDivision implements FromArray
{
    public function __construct(
        public ?int $division,
        public ?string $name,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            division: $data['division'] ?? null,
            name: $data['name'] ?? null,
        );
    }
}
