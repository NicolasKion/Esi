<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class LoyaltyOffer extends Dto
{
    /**
     * @param  array<int, LoyaltyRequiredItem>  $required_items
     */
    public function __construct(
        public int $offer_id,
        public int $type_id,
        public int $quantity,
        public int $lp_cost,
        public int $isk_cost,
        public ?int $ak_cost,
        public array $required_items,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            offer_id: $data->integer('offer_id', 0),
            type_id: $data->integer('type_id', 0),
            quantity: $data->integer('quantity', 0),
            lp_cost: $data->integer('lp_cost', 0),
            isk_cost: $data->integer('isk_cost', 0),
            ak_cost: $data->integer('ak_cost'),
            required_items: $data->list('required_items', LoyaltyRequiredItem::fromData(...)),
        );
    }
}
