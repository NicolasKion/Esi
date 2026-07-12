<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CorporationDivision extends Dto
{
    public function __construct(
        public ?int $division,
        public ?string $name,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            division: $data->integer('division'),
            name: $data->string('name'),
        );
    }
}
