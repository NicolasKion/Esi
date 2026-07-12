<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Enums\LocationFlag;
use NicolasKion\Esi\Enums\LocationType;
use NicolasKion\Esi\Support\Data;

readonly class Asset extends Dto
{
    public function __construct(
        public ?bool $is_blueprint_copy,
        public bool $is_singleton,
        public int $item_id,
        public LocationFlag $location_flag,
        public int $location_id,
        public LocationType $location_type,
        public int $quantity,
        public int $type_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            is_blueprint_copy: $data->boolean('is_blueprint_copy'),
            is_singleton: $data->boolean('is_singleton', false),
            item_id: $data->integer('item_id', 0),
            location_flag: LocationFlag::from($data->string('location_flag', '')),
            location_id: $data->integer('location_id', 0),
            location_type: LocationType::from($data->string('location_type', '')),
            quantity: $data->integer('quantity', 0),
            type_id: $data->integer('type_id', 0),
        );
    }
}
