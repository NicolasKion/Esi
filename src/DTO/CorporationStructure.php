<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class CorporationStructure implements FromArray
{
    /**
     * @param  CorporationStructureService[]  $services
     */
    public function __construct(
        public int $corporation_id,
        public int $profile_id,
        public string $state,
        public int $structure_id,
        public int $system_id,
        public int $type_id,
        public ?string $name,
        public ?string $fuel_expires,
        public ?int $reinforce_hour,
        public ?int $next_reinforce_hour,
        public ?string $next_reinforce_apply,
        public ?string $state_timer_start,
        public ?string $state_timer_end,
        public ?string $unanchors_at,
        public array $services,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            corporation_id: $data['corporation_id'],
            profile_id: $data['profile_id'],
            state: $data['state'],
            structure_id: $data['structure_id'],
            system_id: $data['system_id'],
            type_id: $data['type_id'],
            name: $data['name'] ?? null,
            fuel_expires: $data['fuel_expires'] ?? null,
            reinforce_hour: $data['reinforce_hour'] ?? null,
            next_reinforce_hour: $data['next_reinforce_hour'] ?? null,
            next_reinforce_apply: $data['next_reinforce_apply'] ?? null,
            state_timer_start: $data['state_timer_start'] ?? null,
            state_timer_end: $data['state_timer_end'] ?? null,
            unanchors_at: $data['unanchors_at'] ?? null,
            services: array_map(CorporationStructureService::fromArray(...), $data['services'] ?? []),
        );
    }
}
