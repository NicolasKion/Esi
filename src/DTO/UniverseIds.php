<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class UniverseIds extends Dto
{
    /**
     * @param  array<int, UniverseId>  $agents
     * @param  array<int, UniverseId>  $alliances
     * @param  array<int, UniverseId>  $characters
     * @param  array<int, UniverseId>  $constellations
     * @param  array<int, UniverseId>  $corporations
     * @param  array<int, UniverseId>  $factions
     * @param  array<int, UniverseId>  $inventory_types
     * @param  array<int, UniverseId>  $regions
     * @param  array<int, UniverseId>  $stations
     * @param  array<int, UniverseId>  $systems
     */
    public function __construct(
        public array $agents,
        public array $alliances,
        public array $characters,
        public array $constellations,
        public array $corporations,
        public array $factions,
        public array $inventory_types,
        public array $regions,
        public array $stations,
        public array $systems,
    ) {
        //
    }

    public static function fromData(Data $data): self
    {
        return new self(
            agents: $data->list('agents', UniverseId::fromData(...)),
            alliances: $data->list('alliances', UniverseId::fromData(...)),
            characters: $data->list('characters', UniverseId::fromData(...)),
            constellations: $data->list('constellations', UniverseId::fromData(...)),
            corporations: $data->list('corporations', UniverseId::fromData(...)),
            factions: $data->list('factions', UniverseId::fromData(...)),
            inventory_types: $data->list('inventory_types', UniverseId::fromData(...)),
            regions: $data->list('regions', UniverseId::fromData(...)),
            stations: $data->list('stations', UniverseId::fromData(...)),
            systems: $data->list('systems', UniverseId::fromData(...)),
        );
    }
}
