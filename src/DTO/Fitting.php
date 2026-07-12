<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Fitting extends Dto
{
    /**
     * @param  array<int, FittingItem>  $items
     */
    public function __construct(
        public string $description,
        public int $fitting_id,
        public string $name,
        public int $ship_type_id,
        public array $items,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            description: $data->string('description', ''),
            fitting_id: $data->integer('fitting_id', 0),
            name: $data->string('name', ''),
            ship_type_id: $data->integer('ship_type_id', 0),
            items: $data->list('items', FittingItem::fromData(...)),
        );
    }
}
