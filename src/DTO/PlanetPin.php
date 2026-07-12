<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class PlanetPin extends Dto
{
    /**
     * @param  array<int, PinContent>|null  $contents
     */
    public function __construct(
        public float $latitude,
        public float $longitude,
        public int $pin_id,
        public int $type_id,
        public ?string $expiry_time,
        public ?string $install_time,
        public ?string $last_cycle_start,
        public ?int $schematic_id,
        public ?array $contents,
        public ?ExtractorDetails $extractor_details,
        public ?FactoryDetails $factory_details,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            latitude: $data->float('latitude', 0.0),
            longitude: $data->float('longitude', 0.0),
            pin_id: $data->integer('pin_id', 0),
            type_id: $data->integer('type_id', 0),
            expiry_time: $data->string('expiry_time'),
            install_time: $data->string('install_time'),
            last_cycle_start: $data->string('last_cycle_start'),
            schematic_id: $data->integer('schematic_id'),
            contents: $data->has('contents') ? $data->list('contents', PinContent::fromData(...)) : null,
            extractor_details: $data->has('extractor_details') ? ExtractorDetails::fromData($data->object('extractor_details')) : null,
            factory_details: $data->has('factory_details') ? FactoryDetails::fromData($data->object('factory_details')) : null,
        );
    }
}
