<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

class Ally implements FromArray
{
    public function __construct(
        public ?int $alliance_id,
        public ?int $corporation_id,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            alliance_id: $data['alliance_id'] ?? null,
            corporation_id: $data['corporation_id'] ?? null,
        );
    }
}
