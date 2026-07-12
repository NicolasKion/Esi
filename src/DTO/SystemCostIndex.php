<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class SystemCostIndex extends Dto
{
    public function __construct(
        public string $activity,
        public float $cost_index,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            activity: $data->string('activity', ''),
            cost_index: $data->float('cost_index', 0.0),
        );
    }
}
