<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class SovereigntyHubUpgrade extends Dto
{
    public function __construct(
        public int $type_id,
        public string $power_state,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            type_id: $data->integer('type_id', 0),
            power_state: $data->string('power_state', ''),
        );
    }
}
