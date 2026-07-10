<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class UniverseIds implements FromArray
{
    /**
     * @param  UniverseId[]  $agents
     * @param  UniverseId[]  $alliances
     * @param  UniverseId[]  $characters
     * @param  UniverseId[]  $constellations
     * @param  UniverseId[]  $corporations
     * @param  UniverseId[]  $factions
     * @param  UniverseId[]  $inventory_types
     * @param  UniverseId[]  $regions
     * @param  UniverseId[]  $stations
     * @param  UniverseId[]  $systems
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

    public static function fromArray(array $data): self
    {
        return new self(
            agents: array_map(UniverseId::fromArray(...), $data['agents'] ?? []),
            alliances: array_map(UniverseId::fromArray(...), $data['alliances'] ?? []),
            characters: array_map(UniverseId::fromArray(...), $data['characters'] ?? []),
            constellations: array_map(UniverseId::fromArray(...), $data['constellations'] ?? []),
            corporations: array_map(UniverseId::fromArray(...), $data['corporations'] ?? []),
            factions: array_map(UniverseId::fromArray(...), $data['factions'] ?? []),
            inventory_types: array_map(UniverseId::fromArray(...), $data['inventory_types'] ?? []),
            regions: array_map(UniverseId::fromArray(...), $data['regions'] ?? []),
            stations: array_map(UniverseId::fromArray(...), $data['stations'] ?? []),
            systems: array_map(UniverseId::fromArray(...), $data['systems'] ?? []),
        );
    }
}
