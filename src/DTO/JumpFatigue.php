<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class JumpFatigue extends Dto
{
    public function __construct(
        public ?string $jump_fatigue_expire_date,
        public ?string $last_jump_date,
        public ?string $last_update_date,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            jump_fatigue_expire_date: $data->string('jump_fatigue_expire_date'),
            last_jump_date: $data->string('last_jump_date'),
            last_update_date: $data->string('last_update_date'),
        );
    }
}
