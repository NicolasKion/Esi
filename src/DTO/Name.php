<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Enums\NameCategory;
use NicolasKion\Esi\Interfaces\FromArray;

readonly class Name implements FromArray
{
    public function __construct(
        public NameCategory $category,
        public int $id,
        public string $name,
    ) {
        //
    }

    public static function fromArray(array $data): FromArray
    {
        return new self(
            NameCategory::from($data['category']),
            $data['id'],
            $data['name'],
        );
    }
}
