<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class CharacterAffiliation implements FromArray
{
    public function __construct(
        public int $character_id,
        public int $corporation_id,
        public ?int $alliance_id,
        public ?int $faction_id,
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            character_id: $data['character_id'],
            corporation_id: $data['corporation_id'],
            alliance_id: $data['alliance_id'] ?? null,
            faction_id: $data['faction_id'] ?? null,
        );
    }
}
