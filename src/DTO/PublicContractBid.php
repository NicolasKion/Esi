<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class PublicContractBid implements FromArray
{
    public function __construct(
        public float $amount,
        public int $bid_id,
        public string $date_bid,
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new PublicContractBid(
            amount: (float) $data['amount'],
            bid_id: (int) $data['bid_id'],
            date_bid: $data['date_bid'],
        );
    }
}
