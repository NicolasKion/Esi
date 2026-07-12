<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CorporationStructure extends Dto
{
    /**
     * @param  array<int, CorporationStructureService>  $services
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

    public static function fromData(Data $data): self
    {
        return new self(
            corporation_id: $data->integer('corporation_id', 0),
            profile_id: $data->integer('profile_id', 0),
            state: $data->string('state', ''),
            structure_id: $data->integer('structure_id', 0),
            system_id: $data->integer('system_id', 0),
            type_id: $data->integer('type_id', 0),
            name: $data->string('name'),
            fuel_expires: $data->string('fuel_expires'),
            reinforce_hour: $data->integer('reinforce_hour'),
            next_reinforce_hour: $data->integer('next_reinforce_hour'),
            next_reinforce_apply: $data->string('next_reinforce_apply'),
            state_timer_start: $data->string('state_timer_start'),
            state_timer_end: $data->string('state_timer_end'),
            unanchors_at: $data->string('unanchors_at'),
            services: $data->list('services', CorporationStructureService::fromData(...)),
        );
    }
}
