<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

readonly class EsiError
{
    public function __construct(
        public int     $code,
        public ?string $body,
    )
    {
        //
    }
}
