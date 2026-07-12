<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * An open market order placed by a character or on behalf of a corporation.
 *
 * Unlike the public region {@see MarketOrder}, this carries escrow and
 * ownership information. `is_corporation` is only ever present on character
 * orders (whether the order was placed on the corporation's behalf), while
 * `issued_by` and `wallet_division` are only ever present on corporation
 * orders (who issued it and which wallet division it is billed against) —
 * both sides are nullable here since a single DTO is shared between the two
 * endpoints.
 */
readonly class PersonalMarketOrder extends Dto
{
    public function __construct(
        public int $order_id,
        public int $type_id,
        public int $location_id,
        public int $region_id,
        public int $duration,
        public bool $is_buy_order,
        public ?bool $is_corporation,
        public string $issued,
        public ?int $issued_by,
        public int $min_volume,
        public ?float $escrow,
        public float $price,
        public string $range,
        public int $volume_remain,
        public int $volume_total,
        public ?int $wallet_division,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            order_id: $data->integer('order_id', 0),
            type_id: $data->integer('type_id', 0),
            location_id: $data->integer('location_id', 0),
            region_id: $data->integer('region_id', 0),
            duration: $data->integer('duration', 0),
            is_buy_order: $data->boolean('is_buy_order', false),
            is_corporation: $data->boolean('is_corporation'),
            issued: $data->string('issued', ''),
            issued_by: $data->integer('issued_by'),
            min_volume: $data->integer('min_volume', 0),
            escrow: $data->float('escrow'),
            price: $data->float('price', 0.0),
            range: $data->string('range', ''),
            volume_remain: $data->integer('volume_remain', 0),
            volume_total: $data->integer('volume_total', 0),
            wallet_division: $data->integer('wallet_division'),
        );
    }
}
