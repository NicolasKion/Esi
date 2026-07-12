<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class PlanetRoute extends Dto
{
    /**
     * @param  array<int, int>  $waypoints
     */
    public function __construct(
        public int $content_type_id,
        public int $destination_pin_id,
        public float $quantity,
        public int $route_id,
        public int $source_pin_id,
        public array $waypoints,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            content_type_id: $data->integer('content_type_id', 0),
            destination_pin_id: $data->integer('destination_pin_id', 0),
            quantity: $data->float('quantity', 0.0),
            route_id: $data->integer('route_id', 0),
            source_pin_id: $data->integer('source_pin_id', 0),
            waypoints: $data->integers('waypoints'),
        );
    }
}
