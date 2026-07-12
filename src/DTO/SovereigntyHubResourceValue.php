<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * An allocated/available pair, used for both the power and workforce
 * resources of a Sovereignty Hub.
 */
readonly class SovereigntyHubResourceValue extends Dto
{
    public function __construct(
        public int $allocated,
        public int $available,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            allocated: $data->integer('allocated', 0),
            available: $data->integer('available', 0),
        );
    }
}
