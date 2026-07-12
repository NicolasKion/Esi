<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * The result of a character search, grouped by category. Every property
 * defaults to an empty array when its category was not requested or had no
 * matches.
 */
readonly class SearchResult extends Dto
{
    /**
     * @param  array<int, int>  $agent
     * @param  array<int, int>  $alliance
     * @param  array<int, int>  $character
     * @param  array<int, int>  $constellation
     * @param  array<int, int>  $corporation
     * @param  array<int, int>  $faction
     * @param  array<int, int>  $inventory_type
     * @param  array<int, int>  $region
     * @param  array<int, int>  $solar_system
     * @param  array<int, int>  $station
     * @param  array<int, int>  $structure
     */
    public function __construct(
        public array $agent,
        public array $alliance,
        public array $character,
        public array $constellation,
        public array $corporation,
        public array $faction,
        public array $inventory_type,
        public array $region,
        public array $solar_system,
        public array $station,
        public array $structure,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            agent: $data->integers('agent'),
            alliance: $data->integers('alliance'),
            character: $data->integers('character'),
            constellation: $data->integers('constellation'),
            corporation: $data->integers('corporation'),
            faction: $data->integers('faction'),
            inventory_type: $data->integers('inventory_type'),
            region: $data->integers('region'),
            solar_system: $data->integers('solar_system'),
            station: $data->integers('station'),
            structure: $data->integers('structure'),
        );
    }
}
