<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class AssetName implements FromArray
{
    public function __construct(
        public int    $item_id,
        public string $name,
    )
    {

    }

    public static function fromArray(array $data): self
    {
        return new self(
            item_id: $data['item_id'],
            name: $data['name']
        );
    }
}
