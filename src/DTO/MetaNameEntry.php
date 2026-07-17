<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * A single historical name of ESI, listed in {@see MetaName}.
 */
readonly class MetaNameEntry extends Dto
{
    public function __construct(
        public string $date,
        public string $name,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            date: $data->string('date', ''),
            name: $data->string('name', ''),
        );
    }
}
