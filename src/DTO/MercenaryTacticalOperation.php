<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * A mercenary tactical operation offered by a mercenary den.
 *
 * This is a superset of the two shapes ESI returns: the listing endpoint
 * only reports `id` and `mercenary_den_id`, while the detail endpoint adds
 * `state`, `dungeon_type_id` and `expires`. Fields only present in the
 * detail response are nullable.
 */
readonly class MercenaryTacticalOperation extends Dto
{
    public function __construct(
        public string $id,
        public int $mercenary_den_id,
        public ?string $state,
        public ?int $dungeon_type_id,
        public ?string $expires,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            id: $data->string('id', ''),
            mercenary_den_id: $data->integer('mercenary_den_id', 0),
            state: $data->string('state'),
            dungeon_type_id: $data->integer('dungeon_type_id'),
            expires: $data->string('expires'),
        );
    }
}
