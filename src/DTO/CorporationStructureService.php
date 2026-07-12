<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CorporationStructureService extends Dto
{
    public function __construct(
        public string $name,
        public string $state,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            name: $data->string('name', ''),
            state: $data->string('state', ''),
        );
    }
}
