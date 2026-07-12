<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Race extends Dto
{
    public function __construct(
        public int $race_id,
        public string $name,
        public string $description,
        public int $alliance_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            race_id: $data->integer('race_id', 0),
            name: $data->string('name', ''),
            description: $data->string('description', ''),
            alliance_id: $data->integer('alliance_id', 0),
        );
    }
}
