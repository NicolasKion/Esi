<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * The Skyhook a Mercenary Den is attached to, as embedded in the den's
 * detail response.
 */
readonly class MercenaryDenSkyhook extends Dto
{
    public function __construct(
        public int $id,
        public int $planet_id,
        public int $corporation_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            id: $data->integer('id', 0),
            planet_id: $data->integer('planet_id', 0),
            corporation_id: $data->integer('corporation_id', 0),
        );
    }
}
