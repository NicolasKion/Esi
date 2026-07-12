<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class UniverseCategory extends Dto
{
    /**
     * @param  array<int, int>  $groups
     */
    public function __construct(
        public int $category_id,
        public string $name,
        public bool $published,
        public array $groups,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            category_id: $data->integer('category_id', 0),
            name: $data->string('name', ''),
            published: $data->boolean('published', false),
            groups: $data->integers('groups'),
        );
    }
}
