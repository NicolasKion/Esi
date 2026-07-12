<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Constellation extends Dto
{
    /**
     * @param  array<int, int>  $systems
     */
    public function __construct(
        public int $constellation_id,
        public string $name,
        public Position $position,
        public int $region_id,
        public array $systems,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            constellation_id: $data->integer('constellation_id', 0),
            name: $data->string('name', ''),
            position: Position::fromData($data->object('position')),
            region_id: $data->integer('region_id', 0),
            systems: $data->integers('systems'),
        );
    }
}
