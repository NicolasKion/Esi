<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

readonly class Corporation
{
    public function __construct(
        public ?int $alliance_id,
        public int $ceo_id,
        public int $creator_id,
        public string $date_founded,
        public string $description,
        public ?int $faction_id,
        public ?int $home_station_id,
        public int $member_count,
        public string $name,
        public ?int $shares,
        public float $tax_rate,
        public string $ticker,
        public string $url,
        public ?bool $war_eligible,
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            alliance_id: (int) ($data['alliance_id'] ?? null),
            ceo_id: (int) $data['ceo_id'],
            creator_id: (int) $data['creator_id'],
            date_founded: $data['date_founded'],
            description: $data['description'],
            faction_id: $data['faction_id'] ?? null,
            home_station_id: $data['home_station_id'] ?? null,
            member_count: (int) $data['member_count'],
            name: $data['name'],
            shares: $data['shares'] ?? null,
            tax_rate: (float) $data['tax_rate'],
            ticker: $data['ticker'],
            url: $data['url'] ?? null,
            war_eligible: $data['war_eligible'] ?? null,
        );
    }
}
