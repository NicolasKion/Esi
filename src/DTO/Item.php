<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

class Item
{
    public function __construct(
        public int $flag,
        public int $item_type_id,
        public ?int $quantity_destroyed = null,
        public ?int $quantity_dropped = null,
        public ?int $singleton = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            flag: $data['flag'],
            item_type_id: $data['item_type_id'],
            quantity_destroyed: $data['quantity_destroyed'] ?? null,
            quantity_dropped: $data['quantity_dropped'] ?? null,
            singleton: $data['singleton'] ?? null,
        );
    }
}
