<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Victim extends Dto
{
    /**
     * @param  array<int, Item>|null  $items
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

    public static function fromData(Data $data): self
    {
        return new self(
            damage_taken: $data->integer('damage_taken', 0),
            ship_type_id: $data->integer('ship_type_id'),
            character_id: $data->integer('character_id'),
            corporation_id: $data->integer('corporation_id'),
            alliance_id: $data->integer('alliance_id'),
            faction_id: $data->integer('faction_id'),
            items: $data->has('items') ? $data->list('items', Item::fromData(...)) : null,
            position: $data->has('position') ? Position::fromData($data->object('position')) : null,
        );
    }
}
