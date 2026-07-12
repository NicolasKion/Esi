<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class MercenaryDenInfomorphs extends Dto
{
    public function __construct(
        public int $amount,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            amount: $data->integer('amount', 0),
        );
    }
}
