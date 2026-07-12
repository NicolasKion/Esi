<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class UniverseId extends Dto
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
        //
    }

    public static function fromData(Data $data): self
    {
        return new self(
            id: $data->integer('id', 0),
            name: $data->string('name', ''),
        );
    }
}
