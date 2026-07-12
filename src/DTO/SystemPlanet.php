<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class SystemPlanet extends Dto
{
    /**
     * @param  array<int, int>  $asteroid_belts
     * @param  array<int, int>  $moons
     */
    public function __construct(
        public int $planet_id,
        public array $asteroid_belts,
        public array $moons,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            planet_id: $data->integer('planet_id', 0),
            asteroid_belts: $data->integers('asteroid_belts'),
            moons: $data->integers('moons'),
        );
    }
}
