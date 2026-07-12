<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * The health status of every ESI route.
 */
readonly class MetaStatus extends Dto
{
    /**
     * @param  array<int, MetaRoute>  $routes
     */
    public function __construct(
        public array $routes,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            routes: $data->list('routes', MetaRoute::fromData(...)),
        );
    }
}
