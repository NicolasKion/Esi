<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class PublicContractItem implements FromArray
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
    ) {
        //
    }

    public static function fromArray(array $data): FromArray
    {
        return new self(
            type_id: (int) $data['type_id'],
            record_id: (int) $data['record_id'],
            quantity: (int) $data['quantity'],
            is_included: (bool) $data['is_included'],
            item_id: $data['item_id'] ?? null,
            is_blueprint_copy: $data['is_blueprint_copy'] ?? null,
            material_efficiency: $data['material_efficiency'] ?? null,
            time_efficiency: $data['time_efficiency'] ?? null,
            runs: $data['runs'] ?? null,
        );
    }
}
