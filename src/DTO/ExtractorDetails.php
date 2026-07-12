<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class ExtractorDetails extends Dto
{
    /**
     * @param  array<int, ExtractorHead>  $heads
     */
    public function __construct(
        public ?int $cycle_time,
        public ?float $head_radius,
        public ?int $product_type_id,
        public ?int $qty_per_cycle,
        public array $heads,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            cycle_time: $data->integer('cycle_time'),
            head_radius: $data->float('head_radius'),
            product_type_id: $data->integer('product_type_id'),
            qty_per_cycle: $data->integer('qty_per_cycle'),
            heads: $data->list('heads', ExtractorHead::fromData(...)),
        );
    }
}
