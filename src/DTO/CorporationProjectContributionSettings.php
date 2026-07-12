<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * The contribution rules configured for a project (limits, ISK reward per
 * contribution, and progress multiplier). Not to be confused with
 * {@see ProjectContribution}, which reports a single character's actual
 * contribution to a project.
 */
readonly class CorporationProjectContributionSettings extends Dto
{
    public function __construct(
        public ?int $participation_limit,
        public ?float $reward_per_contribution,
        public ?int $submission_limit,
        public ?float $submission_multiplier,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            participation_limit: $data->integer('participation_limit'),
            reward_per_contribution: $data->float('reward_per_contribution'),
            submission_limit: $data->integer('submission_limit'),
            submission_multiplier: $data->float('submission_multiplier'),
        );
    }
}
