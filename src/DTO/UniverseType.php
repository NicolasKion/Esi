<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class UniverseType extends Dto
{
    /**
     * @param  array<int, DogmaItemAttribute>  $dogma_attributes
     * @param  array<int, DogmaItemEffect>  $dogma_effects
     */
    public function __construct(
        public int $type_id,
        public string $name,
        public string $description,
        public bool $published,
        public int $group_id,
        public ?float $capacity,
        public array $dogma_attributes,
        public array $dogma_effects,
        public ?int $graphic_id,
        public ?int $icon_id,
        public ?int $market_group_id,
        public ?float $mass,
        public ?float $packaged_volume,
        public ?int $portion_size,
        public ?float $radius,
        public ?float $volume,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            type_id: $data->integer('type_id', 0),
            name: $data->string('name', ''),
            description: $data->string('description', ''),
            published: $data->boolean('published', false),
            group_id: $data->integer('group_id', 0),
            capacity: $data->float('capacity'),
            dogma_attributes: $data->list('dogma_attributes', DogmaItemAttribute::fromData(...)),
            dogma_effects: $data->list('dogma_effects', DogmaItemEffect::fromData(...)),
            graphic_id: $data->integer('graphic_id'),
            icon_id: $data->integer('icon_id'),
            market_group_id: $data->integer('market_group_id'),
            mass: $data->float('mass'),
            packaged_volume: $data->float('packaged_volume'),
            portion_size: $data->integer('portion_size'),
            radius: $data->float('radius'),
            volume: $data->float('volume'),
        );
    }
}
