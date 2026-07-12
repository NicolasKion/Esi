<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class MiningObserverEntry extends Dto
{
    public function __construct(
        public string $last_updated,
        public int $character_id,
        public int $recorded_corporation_id,
        public int $type_id,
        public int $quantity,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            last_updated: $data->string('last_updated', ''),
            character_id: $data->integer('character_id', 0),
            recorded_corporation_id: $data->integer('recorded_corporation_id', 0),
            type_id: $data->integer('type_id', 0),
            quantity: $data->integer('quantity', 0),
        );
    }
}
