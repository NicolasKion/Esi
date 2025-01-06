<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Enums\ContractType;
use NicolasKion\Esi\Interfaces\FromArray;

readonly class PublicContract implements FromArray
{
    public function __construct(
        public int          $contract_id,
        public int          $issuer_id,
        public int          $issuer_corporation_id,
        public string       $date_issued,
        public string       $date_expired,
        public ContractType $type,
        public ?float       $buyout,
        public ?float       $collateral,
        public ?int         $days_to_complete,
        public ?int         $start_location_id,
        public ?int         $end_location_id,
        public ?bool        $for_corporation,
        public ?float       $price,
        public ?float       $reward,
        public ?float       $volume,
        public ?string      $title,
    )
    {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            contract_id: (int)$data['contract_id'],
            issuer_id: (int)$data['issuer_id'],
            issuer_corporation_id: (int)$data['issuer_corporation_id'],
            date_issued: $data['date_issued'],
            date_expired: $data['date_expired'],
            type: ContractType::from($data['type']),
            buyout: $data['buyout'] ?? null,
            collateral: $data['collateral'] ?? null,
            days_to_complete: $data['days_to_complete'] ?? null,
            start_location_id: $data['start_location_id'] ?? null,
            end_location_id: $data['end_location_id'] ?? null,
            for_corporation: $data['for_corporation'] ?? null,
            price: $data['price'] ?? null,
            reward: $data['reward'] ?? null,
            volume: $data['volume'] ?? null,
            title: $data['title'] ?? null,
        );
    }
}
