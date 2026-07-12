<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class InsurancePrice extends Dto
{
    /**
     * @param  array<int, InsuranceLevel>  $levels
     */
    public function __construct(
        public int $type_id,
        public array $levels,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            type_id: $data->integer('type_id', 0),
            levels: $data->list('levels', InsuranceLevel::fromData(...)),
        );
    }
}
