<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CorporationMedal extends Dto
{
    public function __construct(
        public string $created_at,
        public int $creator_id,
        public string $description,
        public int $medal_id,
        public string $title,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            created_at: $data->string('created_at', ''),
            creator_id: $data->integer('creator_id', 0),
            description: $data->string('description', ''),
            medal_id: $data->integer('medal_id', 0),
            title: $data->string('title', ''),
        );
    }
}
