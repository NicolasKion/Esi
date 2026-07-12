<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Corporation extends Dto
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
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            alliance_id: $data->integer('alliance_id'),
            ceo_id: $data->integer('ceo_id', 0),
            creator_id: $data->integer('creator_id', 0),
            date_founded: $data->string('date_founded', ''),
            description: $data->string('description', ''),
            faction_id: $data->integer('faction_id'),
            home_station_id: $data->integer('home_station_id'),
            member_count: $data->integer('member_count', 0),
            name: $data->string('name', ''),
            shares: $data->integer('shares'),
            tax_rate: $data->float('tax_rate', 0.0),
            ticker: $data->string('ticker', ''),
            url: $data->string('url', ''),
            war_eligible: $data->boolean('war_eligible'),
        );
    }
}
