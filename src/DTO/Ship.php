<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 *The online status of a character
 */
readonly class Ship extends Dto
{
    public function __construct(
        public int $ship_type_id,
        public int $ship_item_id,
        public string $ship_name,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            ship_type_id: $data->integer('ship_type_id', 0),
            ship_item_id: $data->integer('ship_item_id', 0),
            ship_name: $data->string('ship_name', ''),
        );
    }
}
