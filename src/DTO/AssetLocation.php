<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class AssetLocation extends Dto
{
    public function __construct(
        public int $item_id,
        public Position $position,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            item_id: $data->integer('item_id', 0),
            position: Position::fromData($data->object('position')),
        );
    }
}
