<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Item extends Dto
{
    public function __construct(
        public int $flag,
        public int $item_type_id,
        public ?int $quantity_destroyed = null,
        public ?int $quantity_dropped = null,
        public ?int $singleton = null,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            flag: $data->integer('flag', 0),
            item_type_id: $data->integer('item_type_id', 0),
            quantity_destroyed: $data->integer('quantity_destroyed'),
            quantity_dropped: $data->integer('quantity_dropped'),
            singleton: $data->integer('singleton'),
        );
    }
}
