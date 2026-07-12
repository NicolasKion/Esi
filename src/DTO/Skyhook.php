<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * A corporation's Skyhook.
 *
 * This is a superset of the two shapes ESI returns: the listing endpoint
 * only reports `id` and `planet_id`, while the detail endpoint adds the
 * remaining fields. Fields only present in the detail response are nullable.
 */
readonly class Skyhook extends Dto
{
    /**
     * @param  array<int, SkyhookReagent>  $reagents
     */
    public function __construct(
        public int $id,
        public int $planet_id,
        public ?int $effective_workforce,
        public ?bool $is_active,
        public ?string $state,
        public array $reagents,
        public ?string $reinforcement_timer_end,
        public ?SkyhookTheftVulnerability $theft_vulnerability,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            id: $data->integer('id', 0),
            planet_id: $data->integer('planet_id', 0),
            effective_workforce: $data->integer('effective_workforce'),
            is_active: $data->boolean('is_active'),
            state: $data->string('state'),
            reagents: $data->list('reagents', SkyhookReagent::fromData(...)),
            reinforcement_timer_end: $data->has('reinforcement_timer') ? $data->object('reinforcement_timer')->string('end') : null,
            theft_vulnerability: $data->has('theft_vulnerability') ? SkyhookTheftVulnerability::fromData($data->object('theft_vulnerability')) : null,
        );
    }
}
