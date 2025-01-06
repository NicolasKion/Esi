<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Enums\ContractType;
use NicolasKion\Esi\Interfaces\FromArray;

readonly class CharacterContract implements FromArray
{
    public function __construct(
        public int $acceptor_id,
        public int $assignee_id,
        public string $availability,
        public ?float $buyout,
        public ?float $collateral,
        public int $contract_id,
        public ?string $date_accepted,
        public ?string $date_completed,
        public string $date_expired,
        public string $date_issued,
        public ?int $days_to_complete,
        public ?int $end_location_id,
        public bool $for_corporation,
        public int $issuer_corporation_id,
        public int $issuer_id,
        public ?float $price,
        public ?float $reward,
        public ?int $start_location_id,
        public string $status,
        public ?string $title,
        public ContractType $type,
        public ?float $volume,
    ) {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            acceptor_id: (int) $data['acceptor_id'],
            assignee_id: (int) $data['assignee_id'],
            availability: $data['availability'],
            buyout: $data['buyout'] ?? null,
            collateral: $data['collateral'] ?? null,
            contract_id: (int) $data['contract_id'],
            date_accepted: $data['date_accepted'] ?? null,
            date_completed: $data['date_completed'] ?? null,
            date_expired: $data['date_expired'],
            date_issued: $data['date_issued'],
            days_to_complete: $data['days_to_complete'] ?? null,
            end_location_id: $data['end_location_id'] ?? null,
            for_corporation: (bool) $data['for_corporation'],
            issuer_corporation_id: (int) $data['issuer_corporation_id'],
            issuer_id: (int) $data['issuer_id'],
            price: $data['price'] ?? null,
            reward: $data['reward'] ?? null,
            start_location_id: $data['start_location_id'] ?? null,
            status: $data['status'],
            title: $data['title'] ?? null,
            type: ContractType::from($data['type']),
            volume: $data['volume'] ?? null,
        );
    }
}
