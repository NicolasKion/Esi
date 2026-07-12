<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * The progress of a {@see FreelanceJob} towards its desired contribution.
 */
readonly class FreelanceJobProgress extends Dto
{
    public function __construct(
        public int $current,
        public int $desired,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            current: $data->integer('current', 0),
            desired: $data->integer('desired', 0),
        );
    }
}
