<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class MiningLedgerEntry extends Dto
{
    public function __construct(
        public string $date,
        public int $quantity,
        public int $solar_system_id,
        public int $type_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            date: $data->string('date', ''),
            quantity: $data->integer('quantity', 0),
            solar_system_id: $data->integer('solar_system_id', 0),
            type_id: $data->integer('type_id', 0),
        );
    }
}
