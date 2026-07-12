<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * A character's access level within an {@see AccessList}.
 */
readonly class AccessListCharacterEntry extends Dto
{
    public function __construct(
        public int $character_id,
        public string $access,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            character_id: $data->integer('character_id', 0),
            access: $data->string('access', ''),
        );
    }
}
