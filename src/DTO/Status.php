<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 *The online status of a character
 */
readonly class Status extends Dto
{
    public function __construct(
        public int $players,
        public string $server_version,
        public string $start_time,
        public bool $vip,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            players: $data->integer('players', 0),
            server_version: $data->string('server_version', ''),
            start_time: $data->string('start_time', ''),
            vip: $data->boolean('vip', false),
        );
    }
}
