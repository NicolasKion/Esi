<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class SystemJumps extends Dto
{
    public function __construct(
        public int $system_id,
        public int $ship_jumps,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            system_id: $data->integer('system_id', 0),
            ship_jumps: $data->integer('ship_jumps', 0),
        );
    }
}
