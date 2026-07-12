<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Ancestry extends Dto
{
    public function __construct(
        public int $id,
        public string $name,
        public int $bloodline_id,
        public string $description,
        public ?int $icon_id,
        public ?string $short_description,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            id: $data->integer('id', 0),
            name: $data->string('name', ''),
            bloodline_id: $data->integer('bloodline_id', 0),
            description: $data->string('description', ''),
            icon_id: $data->integer('icon_id'),
            short_description: $data->string('short_description'),
        );
    }
}
