<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class IndustrySystem extends Dto
{
    /**
     * @param  array<int, SystemCostIndex>  $cost_indices
     */
    public function __construct(
        public int $solar_system_id,
        public array $cost_indices,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            solar_system_id: $data->integer('solar_system_id', 0),
            cost_indices: $data->list('cost_indices', SystemCostIndex::fromData(...)),
        );
    }
}
