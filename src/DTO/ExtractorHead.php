<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class ExtractorHead extends Dto
{
    public function __construct(
        public int $head_id,
        public float $latitude,
        public float $longitude,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            head_id: $data->integer('head_id', 0),
            latitude: $data->float('latitude', 0.0),
            longitude: $data->float('longitude', 0.0),
        );
    }
}
