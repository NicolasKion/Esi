<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

class Victim
{
    /**
     * @param  Item[]|null  $items
     */
    public function __construct(
        public int $damage_taken,
        public ?int $ship_type_id,
        public ?int $character_id = null,
        public ?int $corporation_id = null,
        public ?int $alliance_id = null,
        public ?int $faction_id = null,
        public ?array $items = null,
        public ?Position $position = null,
    ) {}

    public static function fromArray(array $data): self
    {
        $items = isset($data['items']) ? array_map(fn ($item) => Item::fromArray($item), $data['items']) : null;
        $position = isset($data['position']) ? Position::fromArray($data['position']) : null;

        return new self(
            damage_taken: $data['damage_taken'],
            ship_type_id: $data['ship_type_id'] ?? null,
            character_id: $data['character_id'] ?? null,
            corporation_id: $data['corporation_id'] ?? null,
            alliance_id: $data['alliance_id'] ?? null,
            faction_id: $data['faction_id'] ?? null,
            items: $items,
            position: $position,
        );
    }
}
