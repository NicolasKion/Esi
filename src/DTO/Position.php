<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class Position implements FromArray
{
    public function __construct(
        public float $x,
        public float $y,
        public float $z,
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['x'],
            $data['y'],
            $data['z']
        );
    }
}
