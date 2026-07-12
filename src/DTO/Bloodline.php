<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Bloodline extends Dto
{
    public function __construct(
        public int $bloodline_id,
        public string $name,
        public string $description,
        public int $race_id,
        public int $ship_type_id,
        public int $corporation_id,
        public int $perception,
        public int $willpower,
        public int $charisma,
        public int $memory,
        public int $intelligence,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            bloodline_id: $data->integer('bloodline_id', 0),
            name: $data->string('name', ''),
            description: $data->string('description', ''),
            race_id: $data->integer('race_id', 0),
            ship_type_id: $data->integer('ship_type_id', 0),
            corporation_id: $data->integer('corporation_id', 0),
            perception: $data->integer('perception', 0),
            willpower: $data->integer('willpower', 0),
            charisma: $data->integer('charisma', 0),
            memory: $data->integer('memory', 0),
            intelligence: $data->integer('intelligence', 0),
        );
    }
}
