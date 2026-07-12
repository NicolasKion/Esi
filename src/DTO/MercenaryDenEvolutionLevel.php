<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * A cumulative amount/level pair used by both the "anarchy" and
 * "development" facets of a Mercenary Den's evolution.
 */
readonly class MercenaryDenEvolutionLevel extends Dto
{
    public function __construct(
        public int $amount,
        public string $level,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            amount: $data->integer('amount', 0),
            level: $data->string('level', ''),
        );
    }
}
