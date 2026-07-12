<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CorporationHistory extends Dto
{
    public function __construct(
        public int $corporation_id,
        public ?bool $is_deleted,
        public int $record_id,
        public string $start_date,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            corporation_id: $data->integer('corporation_id', 0),
            is_deleted: $data->boolean('is_deleted'),
            record_id: $data->integer('record_id', 0),
            start_date: $data->string('start_date', ''),
        );
    }
}
