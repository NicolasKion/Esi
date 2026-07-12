<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Enums\NameCategory;
use NicolasKion\Esi\Support\Data;

readonly class Name extends Dto
{
    public function __construct(
        public NameCategory $category,
        public int $id,
        public string $name,
    ) {
        //
    }

    public static function fromData(Data $data): self
    {
        return new self(
            category: NameCategory::from($data->string('category', '')),
            id: $data->integer('id', 0),
            name: $data->string('name', ''),
        );
    }
}
