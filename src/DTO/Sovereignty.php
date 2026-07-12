<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * The sovereignty owner of a solar system.
 */
readonly class Sovereignty extends Dto
{
    public function __construct(
        public int $system_id,
        public ?int $alliance_id = null,
        public ?int $faction_id = null,
        public ?int $corporation_id = null,
    ) {}

    public static function fromData(Data $data): self
    {
        // The /sovereignty/systems endpoint nests the owner inside a `claim`
        // object that is one of `faction`, `alliance` or `unclaimed`.
        $claim = $data->object('claim');
        $alliance = $claim->object('alliance');
        $faction = $claim->object('faction');

        return new self(
            system_id: $data->integer('solar_system_id', $data->integer('system_id', 0)),
            alliance_id: $alliance->integer('alliance_id'),
            faction_id: $faction->integer('faction_id'),
            corporation_id: $alliance->integer('corporation_id'),
        );
    }
}
