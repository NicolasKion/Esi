<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Ally extends Dto
{
    public function __construct(
        public ?int $alliance_id,
        public ?int $corporation_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            alliance_id: $data->integer('alliance_id'),
            corporation_id: $data->integer('corporation_id'),
        );
    }
}
