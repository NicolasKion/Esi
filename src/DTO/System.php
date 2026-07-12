<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class System extends Dto
{
    /**
     * @param  array<int, SystemPlanet>  $planets
     * @param  array<int, int>  $stargates
     * @param  array<int, int>  $stations
     */
    public function __construct(
        public int $system_id,
        public string $name,
        public Position $position,
        public float $security_status,
        public int $constellation_id,
        public array $planets,
        public ?string $security_class,
        public ?int $star_id,
        public array $stargates,
        public array $stations,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            system_id: $data->integer('system_id', 0),
            name: $data->string('name', ''),
            position: Position::fromData($data->object('position')),
            security_status: $data->float('security_status', 0.0),
            constellation_id: $data->integer('constellation_id', 0),
            planets: $data->list('planets', SystemPlanet::fromData(...)),
            security_class: $data->string('security_class'),
            star_id: $data->integer('star_id'),
            stargates: $data->integers('stargates'),
            stations: $data->integers('stations'),
        );
    }
}
