<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Structure extends Dto
{
    public function __construct(
        public string $name,
        public int $owner_id,
        public Position $position,
        public int $solar_system_id,
        public int $type_id) {}

    public static function fromData(Data $data): self
    {
        return new self(
            name: $data->string('name', ''),
            owner_id: $data->integer('owner_id', 0),
            position: Position::fromData($data->object('position')),
            solar_system_id: $data->integer('solar_system_id', 0),
            type_id: $data->integer('type_id', 0),
        );
    }
}
