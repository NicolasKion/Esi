<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class DogmaEffectModifier extends Dto
{
    public function __construct(
        public ?string $domain,
        public ?int $effect_id,
        public ?string $func,
        public ?int $modified_attribute_id,
        public ?int $modifying_attribute_id,
        public ?int $operator,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            domain: $data->string('domain'),
            effect_id: $data->integer('effect_id'),
            func: $data->string('func'),
            modified_attribute_id: $data->integer('modified_attribute_id'),
            modifying_attribute_id: $data->integer('modifying_attribute_id'),
            operator: $data->integer('operator'),
        );
    }
}
