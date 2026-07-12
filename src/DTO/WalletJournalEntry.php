<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Enums\ContextIdType;
use NicolasKion\Esi\Enums\TransactionType;
use NicolasKion\Esi\Support\Data;

readonly class WalletJournalEntry extends Dto
{
    public function __construct(
        public ?float $amount,
        public ?float $balance,
        public ?int $context_id,
        public ?ContextIdType $context_id_type,
        public string $date,
        public ?int $first_party_id,
        public int $id,
        public ?string $reason,
        public TransactionType $ref_type,
        public ?int $second_party_id,
        public ?float $tax,
        public ?int $tax_receiver_id,
        public ?string $description = null,
    ) {}

    public static function fromData(Data $data): self
    {
        $context_id_type = $data->string('context_id_type');

        return new self(
            amount: $data->float('amount'),
            balance: $data->float('balance'),
            context_id: $data->integer('context_id'),
            context_id_type: $context_id_type !== null ? ContextIdType::from($context_id_type) : null,
            date: $data->string('date', ''),
            first_party_id: $data->integer('first_party_id'),
            id: $data->integer('id', 0),
            reason: $data->string('reason'),
            ref_type: TransactionType::from($data->string('ref_type', '')),
            second_party_id: $data->integer('second_party_id'),
            tax: $data->float('tax'),
            tax_receiver_id: $data->integer('tax_receiver_id'),
            description: $data->string('description'),
        );
    }
}
