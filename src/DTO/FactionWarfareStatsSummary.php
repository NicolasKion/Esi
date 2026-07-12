<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class FactionWarfareStatsSummary extends Dto
{
    public function __construct(
        public int $last_week,
        public int $total,
        public int $yesterday,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            last_week: $data->integer('last_week', 0),
            total: $data->integer('total', 0),
            yesterday: $data->integer('yesterday', 0),
        );
    }
}
