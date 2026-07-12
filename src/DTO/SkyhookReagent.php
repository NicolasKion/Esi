<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class SkyhookReagent extends Dto
{
    public function __construct(
        public int $type_id,
        public int $secured_stock,
        public int $unsecured_stock,
        public string $last_cycle,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            type_id: $data->integer('type_id', 0),
            secured_stock: $data->integer('secured_stock', 0),
            unsecured_stock: $data->integer('unsecured_stock', 0),
            last_cycle: $data->string('last_cycle', ''),
        );
    }
}
