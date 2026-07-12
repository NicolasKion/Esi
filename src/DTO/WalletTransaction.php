<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class WalletTransaction extends Dto
{
    public function __construct(
        public int $client_id,
        public string $date,
        public bool $is_buy,
        public int $journal_ref_id,
        public int $location_id,
        public int $quantity,
        public int $transaction_id,
        public int $type_id,
        public float $unit_price,
        public ?bool $is_personal = null,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            client_id: $data->integer('client_id', 0),
            date: $data->string('date', ''),
            is_buy: $data->boolean('is_buy', false),
            journal_ref_id: $data->integer('journal_ref_id', 0),
            location_id: $data->integer('location_id', 0),
            quantity: $data->integer('quantity', 0),
            transaction_id: $data->integer('transaction_id', 0),
            type_id: $data->integer('type_id', 0),
            unit_price: $data->float('unit_price', 0.0),
            is_personal: $data->boolean('is_personal'),
        );
    }
}
