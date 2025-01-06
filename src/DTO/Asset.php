<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Enums\LocationFlag;
use NicolasKion\Esi\Enums\LocationType;
use NicolasKion\Esi\Interfaces\FromArray;

readonly class Asset implements FromArray
{
    function __construct(
        public ?bool        $is_blueprint_copy,
        public bool         $is_singleton,
        public int          $item_id,
        public LocationFlag $location_flag,
        public int          $location_id,
        public LocationType $location_type,
        public int          $quantity,
        public int          $type_id,
    )
    {

    }

    public static function fromArray(array $data): self
    {
        return new self(
            is_blueprint_copy: $data['is_blueprint_copy'] ?? null,
            is_singleton: $data['is_singleton'],
            item_id: $data['item_id'],
            location_flag: LocationFlag::from($data['location_flag']),
            location_id: $data['location_id'],
            location_type: LocationType::from($data['location_type']),
            quantity: $data['quantity'],
            type_id: $data['type_id'],
        );
    }
}

