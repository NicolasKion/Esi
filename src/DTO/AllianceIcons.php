<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class AllianceIcons extends Dto
{
    public function __construct(
        public ?string $px64x64,
        public ?string $px128x128,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            px64x64: $data->string('px64x64'),
            px128x128: $data->string('px128x128'),
        );
    }
}
