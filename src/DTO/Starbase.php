<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Starbase extends Dto
{
    public function __construct(
        public ?int $moon_id,
        public ?string $onlined_since,
        public ?string $reinforced_until,
        public int $starbase_id,
        public ?string $state,
        public int $system_id,
        public int $type_id,
        public ?string $unanchor_at,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            moon_id: $data->integer('moon_id'),
            onlined_since: $data->string('onlined_since'),
            reinforced_until: $data->string('reinforced_until'),
            starbase_id: $data->integer('starbase_id', 0),
            state: $data->string('state'),
            system_id: $data->integer('system_id', 0),
            type_id: $data->integer('type_id', 0),
            unanchor_at: $data->string('unanchor_at'),
        );
    }
}
