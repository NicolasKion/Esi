<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class KillmailRef extends Dto
{
    public function __construct(
        public int $killmail_id,
        public string $killmail_hash,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            killmail_id: $data->integer('killmail_id', 0),
            killmail_hash: $data->string('killmail_hash', ''),
        );
    }
}
