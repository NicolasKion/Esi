<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class SovereigntyHubTransportImport extends Dto
{
    /**
     * @param  array<int, SovereigntyHubTransportSource>  $sources
     */
    public function __construct(
        public array $sources,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            sources: $data->list('sources', SovereigntyHubTransportSource::fromData(...)),
        );
    }
}
