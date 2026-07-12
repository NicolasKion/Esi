<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class SovereigntyHubTransportExport extends Dto
{
    public function __construct(
        public ?int $amount,
        public ?int $solar_system_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            amount: $data->integer('amount'),
            solar_system_id: $data->integer('solar_system_id'),
        );
    }
}
