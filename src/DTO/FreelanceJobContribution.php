<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * The contribution limits of a {@see FreelanceJob}, only present on the
 * detail endpoint.
 */
readonly class FreelanceJobContribution extends Dto
{
    public function __construct(
        public ?int $contribution_per_participant_limit,
        public ?int $max_committed_participants,
        public ?float $reward_per_contribution,
        public ?int $submission_limit,
        public ?float $submission_multiplier,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            contribution_per_participant_limit: $data->integer('contribution_per_participant_limit'),
            max_committed_participants: $data->integer('max_committed_participants'),
            reward_per_contribution: $data->float('reward_per_contribution'),
            submission_limit: $data->integer('submission_limit'),
            submission_multiplier: $data->float('submission_multiplier'),
        );
    }
}
