<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

/**
 *The online status of a character
 */
readonly class Online implements FromArray
{
    public function __construct(
        public bool $online,
        public ?string $last_login = null,
        public ?string $last_logout = null,
        public ?int $logins = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            online: $data['online'],
            last_login: $data['last_login'] ?? null,
            last_logout: $data['last_logout'] ?? null,
            logins: $data['logins'] ?? null,
        );
    }
}
