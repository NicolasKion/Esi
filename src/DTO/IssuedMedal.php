<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class IssuedMedal extends Dto
{
    public function __construct(
        public int $character_id,
        public string $issued_at,
        public int $issuer_id,
        public int $medal_id,
        public string $reason,
        public string $status,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            character_id: $data->integer('character_id', 0),
            issued_at: $data->string('issued_at', ''),
            issuer_id: $data->integer('issuer_id', 0),
            medal_id: $data->integer('medal_id', 0),
            reason: $data->string('reason', ''),
            status: $data->string('status', ''),
        );
    }
}
