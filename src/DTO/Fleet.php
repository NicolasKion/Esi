<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Fleet extends Dto
{
    public function __construct(
        public bool $is_free_move,
        public bool $is_registered,
        public bool $is_voice_enabled,
        public ?string $motd,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            is_free_move: $data->boolean('is_free_move', false),
            is_registered: $data->boolean('is_registered', false),
            is_voice_enabled: $data->boolean('is_voice_enabled', false),
            motd: $data->string('motd'),
        );
    }
}
