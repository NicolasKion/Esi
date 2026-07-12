<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class DogmaAttribute extends Dto
{
    public function __construct(
        public int $attribute_id,
        public ?float $default_value,
        public ?string $description,
        public ?string $display_name,
        public ?bool $high_is_good,
        public ?int $icon_id,
        public ?string $name,
        public ?bool $published,
        public ?bool $stackable,
        public ?int $unit_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            attribute_id: $data->integer('attribute_id', 0),
            default_value: $data->float('default_value'),
            description: $data->string('description'),
            display_name: $data->string('display_name'),
            high_is_good: $data->boolean('high_is_good'),
            icon_id: $data->integer('icon_id'),
            name: $data->string('name'),
            published: $data->boolean('published'),
            stackable: $data->boolean('stackable'),
            unit_id: $data->integer('unit_id'),
        );
    }
}
