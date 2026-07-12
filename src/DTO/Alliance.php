<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Alliance extends Dto
{
    public function __construct(
        public int $creator_corporation_id,
        public int $creator_id,
        public string $date_founded,
        public string $name,
        public string $ticker,
        public ?int $executor_corporation_id = null,
        public ?int $faction_id = null,
    ) {
        //
    }

    public static function fromData(Data $data): self
    {
        return new self(
            creator_corporation_id: $data->integer('creator_corporation_id', 0),
            creator_id: $data->integer('creator_id', 0),
            date_founded: $data->string('date_founded', ''),
            name: $data->string('name', ''),
            ticker: $data->string('ticker', ''),
            executor_corporation_id: $data->integer('executor_corporation_id'),
            faction_id: $data->integer('faction_id'),
        );
    }
}
