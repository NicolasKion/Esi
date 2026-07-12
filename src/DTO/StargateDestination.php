<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class StargateDestination extends Dto
{
    public function __construct(
        public int $system_id,
        public int $stargate_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            system_id: $data->integer('system_id', 0),
            stargate_id: $data->integer('stargate_id', 0),
        );
    }
}
