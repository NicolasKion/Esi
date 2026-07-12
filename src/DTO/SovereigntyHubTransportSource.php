<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * A source solar system for a workforce transport import, used for both the
 * configured (no `amount`) and current-state (with `amount`) shapes; `amount`
 * is nullable to accommodate both.
 */
readonly class SovereigntyHubTransportSource extends Dto
{
    public function __construct(
        public int $solar_system_id,
        public ?int $amount,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            solar_system_id: $data->integer('solar_system_id', 0),
            amount: $data->integer('amount'),
        );
    }
}
