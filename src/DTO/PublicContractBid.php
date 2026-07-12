<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class PublicContractBid extends Dto
{
    public function __construct(
        public float $amount,
        public int $bid_id,
        public string $date_bid,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            amount: $data->float('amount', 0.0),
            bid_id: $data->integer('bid_id', 0),
            date_bid: $data->string('date_bid', ''),
        );
    }
}
