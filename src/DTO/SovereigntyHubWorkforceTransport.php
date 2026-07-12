<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class SovereigntyHubWorkforceTransport extends Dto
{
    public function __construct(
        public ?SovereigntyHubTransportSection $configuration,
        public ?SovereigntyHubTransportSection $state,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            configuration: $data->has('configuration') ? SovereigntyHubTransportSection::fromData($data->object('configuration')) : null,
            state: $data->has('state') ? SovereigntyHubTransportSection::fromData($data->object('state')) : null,
        );
    }
}
