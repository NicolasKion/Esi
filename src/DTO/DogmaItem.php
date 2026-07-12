<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * Represents an item in the ESI API (Dogma Item Attributes and Effects)
 *
 * @property array<int, DogmaItemAttribute> $dogma_attributes
 * @property array<int, DogmaItemEffect> $dogma_effects
 */
readonly class DogmaItem extends Dto
{
    /**
     * @param  array<int, DogmaItemAttribute>  $dogma_attributes
     * @param  array<int, DogmaItemEffect>  $dogma_effects
     */
    public function __construct(
        public int $created_by,
        public array $dogma_attributes,
        public array $dogma_effects,
        public int $mutator_type_id,
        public int $source_type_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            created_by: $data->integer('created_by', 0),
            dogma_attributes: $data->list('dogma_attributes', DogmaItemAttribute::fromData(...)),
            dogma_effects: $data->list('dogma_effects', DogmaItemEffect::fromData(...)),
            mutator_type_id: $data->integer('mutator_type_id', 0),
            source_type_id: $data->integer('source_type_id', 0),
        );
    }
}
