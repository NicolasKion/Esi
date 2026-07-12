<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class PlanetLayout extends Dto
{
    /**
     * @param  array<int, PlanetLink>  $links
     * @param  array<int, PlanetPin>  $pins
     * @param  array<int, PlanetRoute>  $routes
     */
    public function __construct(
        public array $links,
        public array $pins,
        public array $routes,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            links: $data->list('links', PlanetLink::fromData(...)),
            pins: $data->list('pins', PlanetPin::fromData(...)),
            routes: $data->list('routes', PlanetRoute::fromData(...)),
        );
    }
}
