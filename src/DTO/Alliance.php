<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

readonly class Alliance
{
    public function __construct(
        public int    $creator_corporation_id,
        public int    $creator_id,
        public string $date_founded,
        public string $name,
        public string $ticker,
        public ?int   $executor_corporation_id = null,
        public ?int   $faction_id = null,
    )
    {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            creator_corporation_id: (int)$data['creator_corporation_id'],
            creator_id: (int)$data['creator_id'],
            date_founded: $data['date_founded'],
            name: $data['name'],
            ticker: $data['ticker'],
            executor_corporation_id: $data['executor_corporation_id'] ?? null,
            faction_id: $data['faction_id'] ?? null,
        );
    }
}
