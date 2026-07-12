<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Planet extends Dto
{
    public function __construct(
        public int $planet_id,
        public string $name,
        public int $type_id,
        public Position $position,
        public int $system_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            planet_id: $data->integer('planet_id', 0),
            name: $data->string('name', ''),
            type_id: $data->integer('type_id', 0),
            position: Position::fromData($data->object('position')),
            system_id: $data->integer('system_id', 0),
        );
    }
}
