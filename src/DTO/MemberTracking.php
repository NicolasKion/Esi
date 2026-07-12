<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class MemberTracking extends Dto
{
    public function __construct(
        public ?int $base_id,
        public int $character_id,
        public ?int $location_id,
        public ?string $logoff_date,
        public ?string $logon_date,
        public ?int $ship_type_id,
        public ?string $start_date,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            base_id: $data->integer('base_id'),
            character_id: $data->integer('character_id', 0),
            location_id: $data->integer('location_id'),
            logoff_date: $data->string('logoff_date'),
            logon_date: $data->string('logon_date'),
            ship_type_id: $data->integer('ship_type_id'),
            start_date: $data->string('start_date'),
        );
    }
}
