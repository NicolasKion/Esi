<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * An alliance participating in a Freeport Event sovereignty campaign, along
 * with its score.
 */
readonly class SovereigntyCampaignParticipant extends Dto
{
    public function __construct(
        public int $alliance_id,
        public float $score,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            alliance_id: $data->integer('alliance_id', 0),
            score: $data->float('score', 0.0),
        );
    }
}
