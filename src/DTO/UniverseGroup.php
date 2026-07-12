<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class UniverseGroup extends Dto
{
    /**
     * @param  array<int, int>  $types
     */
    public function __construct(
        public int $group_id,
        public string $name,
        public bool $published,
        public int $category_id,
        public array $types,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            group_id: $data->integer('group_id', 0),
            name: $data->string('name', ''),
            published: $data->boolean('published', false),
            category_id: $data->integer('category_id', 0),
            types: $data->integers('types'),
        );
    }
}
