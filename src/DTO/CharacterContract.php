<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Enums\ContractType;
use NicolasKion\Esi\Support\Data;

readonly class CharacterContract extends Dto
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
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            acceptor_id: $data->integer('acceptor_id', 0),
            assignee_id: $data->integer('assignee_id', 0),
            availability: $data->string('availability', ''),
            buyout: $data->float('buyout'),
            collateral: $data->float('collateral'),
            contract_id: $data->integer('contract_id', 0),
            date_accepted: $data->string('date_accepted'),
            date_completed: $data->string('date_completed'),
            date_expired: $data->string('date_expired', ''),
            date_issued: $data->string('date_issued', ''),
            days_to_complete: $data->integer('days_to_complete'),
            end_location_id: $data->integer('end_location_id'),
            for_corporation: $data->boolean('for_corporation', false),
            issuer_corporation_id: $data->integer('issuer_corporation_id', 0),
            issuer_id: $data->integer('issuer_id', 0),
            price: $data->float('price'),
            reward: $data->float('reward'),
            start_location_id: $data->integer('start_location_id'),
            status: $data->string('status', ''),
            title: $data->string('title'),
            type: ContractType::from($data->string('type', '')),
            volume: $data->float('volume'),
        );
    }
}
