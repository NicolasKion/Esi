<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class InsuranceLevel extends Dto
{
    public function __construct(
        public float $cost,
        public string $name,
        public float $payout,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            cost: $data->float('cost', 0.0),
            name: $data->string('name', ''),
            payout: $data->float('payout', 0.0),
        );
    }
}
