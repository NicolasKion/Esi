<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Station extends Dto
{
    /**
     * @param  array<int, string>  $services
     */
    public function __construct(
        public int $station_id,
        public string $name,
        public int $type_id,
        public Position $position,
        public int $system_id,
        public float $reprocessing_efficiency,
        public float $reprocessing_stations_take,
        public float $max_dockable_ship_volume,
        public float $office_rental_cost,
        public array $services,
        public ?int $owner,
        public ?int $race_id,
    ) {}

    public static function fromData(Data $data): self
    {
        $rawServices = $data->raw('services');

        return new self(
            station_id: $data->integer('station_id', 0),
            name: $data->string('name', ''),
            type_id: $data->integer('type_id', 0),
            position: Position::fromData($data->object('position')),
            system_id: $data->integer('system_id', 0),
            reprocessing_efficiency: $data->float('reprocessing_efficiency', 0.0),
            reprocessing_stations_take: $data->float('reprocessing_stations_take', 0.0),
            max_dockable_ship_volume: $data->float('max_dockable_ship_volume', 0.0),
            office_rental_cost: $data->float('office_rental_cost', 0.0),
            services: is_array($rawServices)
                ? array_values(array_map(
                    static fn (mixed $value): string => is_string($value) ? $value : '',
                    $rawServices,
                ))
                : [],
            owner: $data->integer('owner'),
            race_id: $data->integer('race_id'),
        );
    }
}
