<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Moon extends Dto
{
    public function __construct(
        public int $moon_id,
        public string $name,
        public Position $position,
        public int $system_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            moon_id: $data->integer('moon_id', 0),
            name: $data->string('name', ''),
            position: Position::fromData($data->object('position')),
            system_id: $data->integer('system_id', 0),
        );
    }
}
