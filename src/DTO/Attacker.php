<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Attacker extends Dto
{
    public function __construct(
        public int $damage_done,
        public bool $final_blow,
        public float $security_status,
        public ?int $ship_type_id,
        public ?int $character_id = null,
        public ?int $corporation_id = null,
        public ?int $alliance_id = null,
        public ?int $faction_id = null,
        public ?int $weapon_type_id = null,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            damage_done: $data->integer('damage_done', 0),
            final_blow: $data->boolean('final_blow', false),
            security_status: $data->float('security_status', 0.0),
            ship_type_id: $data->integer('ship_type_id'),
            character_id: $data->integer('character_id'),
            corporation_id: $data->integer('corporation_id'),
            alliance_id: $data->integer('alliance_id'),
            faction_id: $data->integer('faction_id'),
            weapon_type_id: $data->integer('weapon_type_id'),
        );
    }
}
