<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * A corporation's access level within an {@see AccessList}.
 */
readonly class AccessListCorporationEntry extends Dto
{
    public function __construct(
        public int $corporation_id,
        public string $access,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            corporation_id: $data->integer('corporation_id', 0),
            access: $data->string('access', ''),
        );
    }
}
