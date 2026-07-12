<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CorporationWallet extends Dto
{
    public function __construct(
        public float $balance,
        public int $division,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            balance: $data->float('balance', 0.0),
            division: $data->integer('division', 0),
        );
    }
}
