<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Position extends Dto
{
    public function __construct(
        public float $x,
        public float $y,
        public float $z,
    ) {
        //
    }

    public static function fromData(Data $data): self
    {
        return new self(
            x: $data->float('x', 0.0),
            y: $data->float('y', 0.0),
            z: $data->float('z', 0.0),
        );
    }
}
