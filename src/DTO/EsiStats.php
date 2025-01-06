<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

readonly class EsiStats
{
    public function __construct(
        public ?string $expires,
        public ?int    $errors_remaining,
        public ?int    $error_limit_reset,
    )
    {
        //
    }
}
