<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Enums\ContractType;
use NicolasKion\Esi\Support\Data;

readonly class PublicContract extends Dto
{
    public function __construct(
        public int $contract_id,
        public int $issuer_id,
        public int $issuer_corporation_id,
        public string $date_issued,
        public string $date_expired,
        public ContractType $type,
        public ?float $buyout,
        public ?float $collateral,
        public ?int $days_to_complete,
        public ?int $start_location_id,
        public ?int $end_location_id,
        public ?bool $for_corporation,
        public ?float $price,
        public ?float $reward,
        public ?float $volume,
        public ?string $title,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            contract_id: $data->integer('contract_id', 0),
            issuer_id: $data->integer('issuer_id', 0),
            issuer_corporation_id: $data->integer('issuer_corporation_id', 0),
            date_issued: $data->string('date_issued', ''),
            date_expired: $data->string('date_expired', ''),
            type: ContractType::from($data->string('type', '')),
            buyout: $data->float('buyout'),
            collateral: $data->float('collateral'),
            days_to_complete: $data->integer('days_to_complete'),
            start_location_id: $data->integer('start_location_id'),
            end_location_id: $data->integer('end_location_id'),
            for_corporation: $data->boolean('for_corporation'),
            price: $data->float('price'),
            reward: $data->float('reward'),
            volume: $data->float('volume'),
            title: $data->string('title'),
        );
    }
}
