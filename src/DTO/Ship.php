<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

/**
 *The online status of a character
 */
readonly class Ship implements FromArray
{
    public function __construct(
        public int $ship_type_id,
        public int $ship_item_id,
        public string $ship_name,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            ship_type_id: $data['ship_type_id'],
            ship_item_id: $data['ship_item_id'],
            ship_name: $data['ship_name'],
        );
    }
}
