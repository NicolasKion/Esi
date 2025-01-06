<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

/**
 * Represents an item in the ESI API (Dogma Item Attributes and Effects)
 *
 * @property DogmaItemAttribute[] $dogma_attributes
 * @property DogmaItemEffect[] $dogma_effects
 */
readonly class DogmaItem implements FromArray
{
    public function __construct(
        public int   $created_by,
        public array $dogma_attributes,
        public array $dogma_effects,
        public int   $mutator_type_id,
        public int   $source_type_id,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        $dogma_attributes = [];
        foreach ($data['dogma_attributes'] as $attribute) {
            $dogma_attributes[] = DogmaItemAttribute::fromArray($attribute);
        }

        $dogma_effects = [];
        foreach ($data['dogma_effects'] as $effect) {
            $dogma_effects[] = DogmaItemEffect::fromArray($effect);
        }

        return new self(
            created_by: $data['created_by'],
            dogma_attributes: $dogma_attributes,
            dogma_effects: $dogma_effects,
            mutator_type_id: $data['mutator_type_id'],
            source_type_id: $data['source_type_id'],
        );
    }
}
