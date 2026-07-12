<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Blueprint extends Dto
{
    public function __construct(
        public int $item_id,
        public string $location_flag,
        public int $location_id,
        public int $material_efficiency,
        public int $quantity,
        public int $runs,
        public int $time_efficiency,
        public int $type_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            item_id: $data->integer('item_id', 0),
            location_flag: $data->string('location_flag', ''),
            location_id: $data->integer('location_id', 0),
            material_efficiency: $data->integer('material_efficiency', 0),
            quantity: $data->integer('quantity', 0),
            runs: $data->integer('runs', 0),
            time_efficiency: $data->integer('time_efficiency', 0),
            type_id: $data->integer('type_id', 0),
        );
    }
}
