<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class SovereigntyHubReagentBay extends Dto
{
    /**
     * @param  array<int, SovereigntyHubReagent>  $reagents
     */
    public function __construct(
        public string $last_updated,
        public array $reagents,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            last_updated: $data->string('last_updated', ''),
            reagents: $data->list('reagents', SovereigntyHubReagent::fromData(...)),
        );
    }
}
