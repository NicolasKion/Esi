<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class MarketOrder extends Dto
{
    public function __construct(
        public int $order_id,
        public int $type_id,
        public int $location_id,
        public ?int $system_id,
        public int $duration,
        public bool $is_buy_order,
        public string $issued,
        public int $min_volume,
        public float $price,
        public string $range,
        public int $volume_remain,
        public int $volume_total,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            order_id: $data->integer('order_id', 0),
            type_id: $data->integer('type_id', 0),
            location_id: $data->integer('location_id', 0),
            system_id: $data->integer('system_id'),
            duration: $data->integer('duration', 0),
            is_buy_order: $data->boolean('is_buy_order', false),
            issued: $data->string('issued', ''),
            min_volume: $data->integer('min_volume', 0),
            price: $data->float('price', 0.0),
            range: $data->string('range', ''),
            volume_remain: $data->integer('volume_remain', 0),
            volume_total: $data->integer('volume_total', 0),
        );
    }
}
