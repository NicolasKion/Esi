<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * A freelance job.
 *
 * This is a superset of the two shapes ESI returns: the listing endpoints
 * only report `id`, `name`, `state`, `last_modified`, `progress` and
 * `reward`, while the detail endpoint adds `access_and_visibility`,
 * `configuration`, `contribution` and `details`. Fields only present in the
 * detail response are nullable.
 */
readonly class FreelanceJob extends Dto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $state,
        public string $last_modified,
        public ?FreelanceJobProgress $progress,
        public ?FreelanceJobReward $reward,
        public ?FreelanceJobAccessAndVisibility $access_and_visibility,
        public ?FreelanceJobConfiguration $configuration,
        public ?FreelanceJobContribution $contribution,
        public ?FreelanceJobDetails $details,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            id: $data->string('id', ''),
            name: $data->string('name', ''),
            state: $data->string('state', ''),
            last_modified: $data->string('last_modified', ''),
            progress: $data->has('progress') ? FreelanceJobProgress::fromData($data->object('progress')) : null,
            reward: $data->has('reward') ? FreelanceJobReward::fromData($data->object('reward')) : null,
            access_and_visibility: $data->has('access_and_visibility') ? FreelanceJobAccessAndVisibility::fromData($data->object('access_and_visibility')) : null,
            configuration: $data->has('configuration') ? FreelanceJobConfiguration::fromData($data->object('configuration')) : null,
            contribution: $data->has('contribution') ? FreelanceJobContribution::fromData($data->object('contribution')) : null,
            details: $data->has('details') ? FreelanceJobDetails::fromData($data->object('details')) : null,
        );
    }
}
