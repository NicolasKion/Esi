<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CharacterAffiliation extends Dto
{
    public function __construct(
        public int $character_id,
        public int $corporation_id,
        public ?int $alliance_id,
        public ?int $faction_id,
    ) {
        //
    }

    public static function fromData(Data $data): self
    {
        return new self(
            character_id: $data->integer('character_id', 0),
            corporation_id: $data->integer('corporation_id', 0),
            alliance_id: $data->integer('alliance_id'),
            faction_id: $data->integer('faction_id'),
        );
    }
}
