<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class PublicContractItem extends Dto
{
    public function __construct(
        public int $type_id,
        public int $record_id,
        public int $quantity,
        public bool $is_included,
        public ?int $item_id,
        public ?bool $is_blueprint_copy,
        public ?int $material_efficiency,
        public ?int $time_efficiency,
        public ?int $runs,
        public ?bool $is_singleton = null,
        public ?int $raw_quantity = null,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            type_id: $data->integer('type_id', 0),
            record_id: $data->integer('record_id', 0),
            quantity: $data->integer('quantity', 0),
            is_included: $data->boolean('is_included', false),
            item_id: $data->integer('item_id'),
            is_blueprint_copy: $data->boolean('is_blueprint_copy'),
            material_efficiency: $data->integer('material_efficiency'),
            time_efficiency: $data->integer('time_efficiency'),
            runs: $data->integer('runs'),
            is_singleton: $data->boolean('is_singleton'),
            raw_quantity: $data->integer('raw_quantity'),
        );
    }
}
