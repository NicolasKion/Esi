<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Enums\ContextIdType;
use NicolasKion\Esi\Enums\TransactionType;
use NicolasKion\Esi\Interfaces\FromArray;

readonly class WalletJournalEntry implements FromArray
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
    ) {}

    public static function fromArray(array $data): self
    {
        return new WalletJournalEntry(
            amount: $data['amount'] ?? null,
            balance: $data['balance'] ?? null,
            context_id: $data['context_id'] ?? null,
            context_id_type: ($context_id_type = $data['context_id_type'] ?? false) ? ContextIdType::from($context_id_type) : null,
            date: $data['date'],
            first_party_id: $data['first_party_id'] ?? null,
            id: $data['id'],
            reason: $data['reason'] ?? null,
            ref_type: TransactionType::from($data['ref_type']),
            second_party_id: $data['second_party_id'] ?? null,
            tax: $data['tax'] ?? null,
            tax_receiver_id: $data['tax_receiver_id'] ?? null,
        );
    }
}
