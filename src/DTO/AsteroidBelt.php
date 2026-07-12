<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class AsteroidBelt extends Dto
{
    public function __construct(
        public string $name,
        public Position $position,
        public int $system_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            name: $data->string('name', ''),
            position: Position::fromData($data->object('position')),
            system_id: $data->integer('system_id', 0),
        );
    }
}
