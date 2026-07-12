<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CorporationIcons extends Dto
{
    public function __construct(
        public ?string $px128x128,
        public ?string $px256x256,
        public ?string $px64x64,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            px128x128: $data->string('px128x128'),
            px256x256: $data->string('px256x256'),
            px64x64: $data->string('px64x64'),
        );
    }
}
