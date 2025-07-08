<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

/**
 *The sovereignty of a system
 */
readonly class Sovereignty implements FromArray
{
    public function __construct(
        public int $system_id,
        public ?int $alliance_id = null,
        public ?int $faction_id = null,
        public ?int $corporation_id = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            system_id: $data['system_id'],
            alliance_id: $data['alliance_id'] ?? null,
            faction_id: $data['faction_id'] ?? null,
            corporation_id: $data['corporation_id'] ?? null,
        );
    }
}
