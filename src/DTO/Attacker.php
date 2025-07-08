<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

class Attacker
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

    public static function fromArray(array $data): self
    {
        return new self(
            damage_done: $data['damage_done'],
            final_blow: (bool) $data['final_blow'],
            security_status: $data['security_status'],
            ship_type_id: $data['ship_type_id'] ?? null,
            character_id: $data['character_id'] ?? null,
            corporation_id: $data['corporation_id'] ?? null,
            alliance_id: $data['alliance_id'] ?? null,
            faction_id: $data['faction_id'] ?? null,
            weapon_type_id: $data['weapon_type_id'] ?? null,
        );
    }
}
