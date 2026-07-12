<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CustomsOffice extends Dto
{
    public function __construct(
        public bool $allow_access_with_standings,
        public bool $allow_alliance_access,
        public int $office_id,
        public int $reinforce_exit_end,
        public int $reinforce_exit_start,
        public int $system_id,
        public ?float $alliance_tax_rate,
        public ?float $bad_standing_tax_rate,
        public ?float $corporation_tax_rate,
        public ?float $excellent_standing_tax_rate,
        public ?float $good_standing_tax_rate,
        public ?float $neutral_standing_tax_rate,
        public ?string $standing_level,
        public ?float $terrible_standing_tax_rate,
        public ?int $type_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            allow_access_with_standings: $data->boolean('allow_access_with_standings', false),
            allow_alliance_access: $data->boolean('allow_alliance_access', false),
            office_id: $data->integer('office_id', 0),
            reinforce_exit_end: $data->integer('reinforce_exit_end', 0),
            reinforce_exit_start: $data->integer('reinforce_exit_start', 0),
            system_id: $data->integer('system_id', 0),
            alliance_tax_rate: $data->float('alliance_tax_rate'),
            bad_standing_tax_rate: $data->float('bad_standing_tax_rate'),
            corporation_tax_rate: $data->float('corporation_tax_rate'),
            excellent_standing_tax_rate: $data->float('excellent_standing_tax_rate'),
            good_standing_tax_rate: $data->float('good_standing_tax_rate'),
            neutral_standing_tax_rate: $data->float('neutral_standing_tax_rate'),
            standing_level: $data->string('standing_level'),
            terrible_standing_tax_rate: $data->float('terrible_standing_tax_rate'),
            type_id: $data->integer('type_id'),
        );
    }
}
