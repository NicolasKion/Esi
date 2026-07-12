<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * A bid on a character's or corporation's own auction contract.
 *
 * Unlike {@see PublicContractBid}, ESI includes the bidder's character ID for
 * these non-public endpoints, so a distinct DTO is used instead of reusing
 * PublicContractBid.
 */
readonly class ContractBid extends Dto
{
    public function __construct(
        public float $amount,
        public int $bid_id,
        public int $bidder_id,
        public string $date_bid,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            amount: $data->float('amount', 0.0),
            bid_id: $data->integer('bid_id', 0),
            bidder_id: $data->integer('bidder_id', 0),
            date_bid: $data->string('date_bid', ''),
        );
    }
}
