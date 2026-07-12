<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Stargate extends Dto
{
    public function __construct(
        public int $stargate_id,
        public string $name,
        public int $type_id,
        public Position $position,
        public int $system_id,
        public StargateDestination $destination,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            stargate_id: $data->integer('stargate_id', 0),
            name: $data->string('name', ''),
            type_id: $data->integer('type_id', 0),
            position: Position::fromData($data->object('position')),
            system_id: $data->integer('system_id', 0),
            destination: StargateDestination::fromData($data->object('destination')),
        );
    }
}
