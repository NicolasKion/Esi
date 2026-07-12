<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Shareholder extends Dto
{
    public function __construct(
        public int $share_count,
        public int $shareholder_id,
        public string $shareholder_type,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            share_count: $data->integer('share_count', 0),
            shareholder_id: $data->integer('shareholder_id', 0),
            shareholder_type: $data->string('shareholder_type', ''),
        );
    }
}
