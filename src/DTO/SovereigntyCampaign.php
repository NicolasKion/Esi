<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * An active sovereignty campaign.
 *
 * `defender_id`, `defender_score` and `attackers_score` are only present on
 * Defense Events (tcu_defense, ihub_defense, station_defense); `participants`
 * is only present on Freeport Events (station_freeport).
 */
readonly class SovereigntyCampaign extends Dto
{
    /**
     * @param  array<int, SovereigntyCampaignParticipant>  $participants
     */
    public function __construct(
        public int $campaign_id,
        public int $structure_id,
        public int $solar_system_id,
        public int $constellation_id,
        public string $event_type,
        public string $start_time,
        public ?int $defender_id,
        public ?float $defender_score,
        public ?float $attackers_score,
        public array $participants,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            campaign_id: $data->integer('campaign_id', 0),
            structure_id: $data->integer('structure_id', 0),
            solar_system_id: $data->integer('solar_system_id', 0),
            constellation_id: $data->integer('constellation_id', 0),
            event_type: $data->string('event_type', ''),
            start_time: $data->string('start_time', ''),
            defender_id: $data->integer('defender_id'),
            defender_score: $data->float('defender_score'),
            attackers_score: $data->float('attackers_score'),
            participants: $data->list('participants', SovereigntyCampaignParticipant::fromData(...)),
        );
    }
}
