<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

/**
 *The online status of a character
 */
readonly class Status implements FromArray
{
    public function __construct(
        public int $players,
        public string $server_version,
        public string $start_time,
        public bool $vip,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            players: $data['players'] ?? 0,
            server_version: $data['server_version'],
            start_time: $data['start_time'],
            vip: $data['vip'] ?? false,
        );
    }
}
