<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class FittingItem extends Dto
{
    public function __construct(
        public string $flag,
        public int $quantity,
        public int $type_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            flag: $data->string('flag', ''),
            quantity: $data->integer('quantity', 0),
            type_id: $data->integer('type_id', 0),
        );
    }
}
