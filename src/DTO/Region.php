<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Region extends Dto
{
    /**
     * @param  array<int, int>  $constellations
     */
    public function __construct(
        public int $region_id,
        public string $name,
        public array $constellations,
        public ?string $description,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            region_id: $data->integer('region_id', 0),
            name: $data->string('name', ''),
            constellations: $data->integers('constellations'),
            description: $data->string('description'),
        );
    }
}
