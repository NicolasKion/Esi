<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Star extends Dto
{
    public function __construct(
        public string $name,
        public int $type_id,
        public int $age,
        public float $luminosity,
        public int $radius,
        public string $spectral_class,
        public int $temperature,
        public int $solar_system_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            name: $data->string('name', ''),
            type_id: $data->integer('type_id', 0),
            age: $data->integer('age', 0),
            luminosity: $data->float('luminosity', 0.0),
            radius: $data->integer('radius', 0),
            spectral_class: $data->string('spectral_class', ''),
            temperature: $data->integer('temperature', 0),
            solar_system_id: $data->integer('solar_system_id', 0),
        );
    }
}
