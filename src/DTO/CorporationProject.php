<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * A corporation project.
 *
 * This is a superset of the two shapes ESI returns: the listing endpoint
 * only reports `id`, `name`, `state`, `last_modified`, and `progress`, while
 * the detail endpoint adds `creator`, `details`, `configuration`, and
 * `contribution`. Fields only present in the detail response are nullable.
 *
 * `configuration` describes a project-type-specific goal (e.g. capturing a
 * faction warfare complex, destroying a ship, delivering an item) as one of
 * 17 differently-shaped variants keyed by type name. It is left as a raw
 * decoded array rather than modeled as individual DTOs for each variant.
 */
readonly class CorporationProject extends Dto
{
    /**
     * @param  array<string, mixed>|null  $configuration
     */
    public function __construct(
        public string $id,
        public string $name,
        public string $state,
        public string $last_modified,
        public CorporationProjectProgress $progress,
        public ?CorporationProjectReward $reward,
        public ?CorporationProjectCreator $creator,
        public ?CorporationProjectDetails $details,
        public ?array $configuration,
        public ?CorporationProjectContributionSettings $contribution,
    ) {}

    public static function fromData(Data $data): self
    {
        /** @var array<string, mixed>|null $configuration */
        $configuration = $data->raw('configuration');

        return new self(
            id: $data->string('id', ''),
            name: $data->string('name', ''),
            state: $data->string('state', ''),
            last_modified: $data->string('last_modified', ''),
            progress: CorporationProjectProgress::fromData($data->object('progress')),
            reward: $data->has('reward') ? CorporationProjectReward::fromData($data->object('reward')) : null,
            creator: $data->has('creator') ? CorporationProjectCreator::fromData($data->object('creator')) : null,
            details: $data->has('details') ? CorporationProjectDetails::fromData($data->object('details')) : null,
            configuration: is_array($configuration) ? $configuration : null,
            contribution: $data->has('contribution') ? CorporationProjectContributionSettings::fromData($data->object('contribution')) : null,
        );
    }
}
