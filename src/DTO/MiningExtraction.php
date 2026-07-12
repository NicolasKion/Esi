<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class MiningExtraction extends Dto
{
    public function __construct(
        public int $structure_id,
        public int $moon_id,
        public string $extraction_start_time,
        public string $chunk_arrival_time,
        public string $natural_decay_time,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            structure_id: $data->integer('structure_id', 0),
            moon_id: $data->integer('moon_id', 0),
            extraction_start_time: $data->string('extraction_start_time', ''),
            chunk_arrival_time: $data->string('chunk_arrival_time', ''),
            natural_decay_time: $data->string('natural_decay_time', ''),
        );
    }
}
