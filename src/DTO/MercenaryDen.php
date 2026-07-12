<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * A character's Mercenary Den.
 *
 * This is a superset of the two shapes ESI returns: the listing endpoint
 * only reports `id` and `planet_id`, while the detail endpoint omits
 * `planet_id` at the top level (it is nested under `skyhook` instead) and
 * adds the remaining fields. Fields that are only present in one of the two
 * shapes are nullable here.
 */
readonly class MercenaryDen extends Dto
{
    public function __construct(
        public int $id,
        public ?int $planet_id,
        public ?string $state,
        public ?int $type_id,
        public ?MercenaryDenSkyhook $skyhook,
        public ?MercenaryDenInfomorphs $infomorphs,
        public ?MercenaryDenEvolution $evolution,
        public ?string $reinforcement_timer_end,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            id: $data->integer('id', 0),
            planet_id: $data->integer('planet_id'),
            state: $data->string('state'),
            type_id: $data->integer('type_id'),
            skyhook: $data->has('skyhook') ? MercenaryDenSkyhook::fromData($data->object('skyhook')) : null,
            infomorphs: $data->has('infomorphs') ? MercenaryDenInfomorphs::fromData($data->object('infomorphs')) : null,
            evolution: $data->has('evolution') ? MercenaryDenEvolution::fromData($data->object('evolution')) : null,
            reinforcement_timer_end: $data->has('reinforcement_timer') ? $data->object('reinforcement_timer')->string('end') : null,
        );
    }
}
