<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * An alliance's access level within an {@see AccessList}.
 */
readonly class AccessListAllianceEntry extends Dto
{
    public function __construct(
        public int $alliance_id,
        public string $access,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            alliance_id: $data->integer('alliance_id', 0),
            access: $data->string('access', ''),
        );
    }
}
