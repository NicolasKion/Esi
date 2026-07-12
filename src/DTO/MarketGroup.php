<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class MarketGroup extends Dto
{
    /**
     * @param  array<int, int>  $types
     */
    public function __construct(
        public int $market_group_id,
        public ?string $description,
        public ?string $name,
        public ?int $parent_group_id,
        public array $types,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            market_group_id: $data->integer('market_group_id', 0),
            description: $data->string('description'),
            name: $data->string('name'),
            parent_group_id: $data->integer('parent_group_id'),
            types: $data->integers('types'),
        );
    }
}
