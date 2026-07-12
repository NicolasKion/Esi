<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class SovereigntyHubResources extends Dto
{
    public function __construct(
        public SovereigntyHubResourceValue $power,
        public SovereigntyHubResourceValue $workforce,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            power: SovereigntyHubResourceValue::fromData($data->object('power')),
            workforce: SovereigntyHubResourceValue::fromData($data->object('workforce')),
        );
    }
}
