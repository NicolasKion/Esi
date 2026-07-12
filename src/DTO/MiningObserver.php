<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class MiningObserver extends Dto
{
    public function __construct(
        public string $last_updated,
        public int $observer_id,
        public string $observer_type,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            last_updated: $data->string('last_updated', ''),
            observer_id: $data->integer('observer_id', 0),
            observer_type: $data->string('observer_type', ''),
        );
    }
}
