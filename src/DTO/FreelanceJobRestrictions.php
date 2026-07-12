<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * Age restrictions on who may participate in a {@see FreelanceJob}.
 */
readonly class FreelanceJobRestrictions extends Dto
{
    public function __construct(
        public ?int $maximum_age,
        public ?int $minimum_age,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            maximum_age: $data->integer('maximum_age'),
            minimum_age: $data->integer('minimum_age'),
        );
    }
}
