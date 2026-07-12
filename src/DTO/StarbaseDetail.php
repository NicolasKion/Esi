<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class StarbaseDetail extends Dto
{
    /**
     * @param  array<int, StarbaseFuel>  $fuels
     */
    public function __construct(
        public bool $allow_alliance_members,
        public bool $allow_corporation_members,
        public string $anchor,
        public bool $attack_if_at_war,
        public bool $attack_if_other_security_status_dropping,
        public ?float $attack_security_status_threshold,
        public ?float $attack_standing_threshold,
        public string $fuel_bay_take,
        public string $fuel_bay_view,
        public array $fuels,
        public string $offline,
        public string $online,
        public string $unanchor,
        public bool $use_alliance_standings,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            allow_alliance_members: $data->boolean('allow_alliance_members', false),
            allow_corporation_members: $data->boolean('allow_corporation_members', false),
            anchor: $data->string('anchor', ''),
            attack_if_at_war: $data->boolean('attack_if_at_war', false),
            attack_if_other_security_status_dropping: $data->boolean('attack_if_other_security_status_dropping', false),
            attack_security_status_threshold: $data->float('attack_security_status_threshold'),
            attack_standing_threshold: $data->float('attack_standing_threshold'),
            fuel_bay_take: $data->string('fuel_bay_take', ''),
            fuel_bay_view: $data->string('fuel_bay_view', ''),
            fuels: $data->list('fuels', StarbaseFuel::fromData(...)),
            offline: $data->string('offline', ''),
            online: $data->string('online', ''),
            unanchor: $data->string('unanchor', ''),
            use_alliance_standings: $data->boolean('use_alliance_standings', false),
        );
    }
}
