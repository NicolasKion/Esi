<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * The ISK reward pool of a {@see FreelanceJob}.
 */
readonly class FreelanceJobReward extends Dto
{
    public function __construct(
        public float $initial,
        public float $remaining,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            initial: $data->float('initial', 0.0),
            remaining: $data->float('remaining', 0.0),
        );
    }
}
