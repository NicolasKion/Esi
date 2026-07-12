<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 *The online status of a character
 */
readonly class Online extends Dto
{
    public function __construct(
        public bool $online,
        public ?string $last_login = null,
        public ?string $last_logout = null,
        public ?int $logins = null,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            online: $data->boolean('online', false),
            last_login: $data->string('last_login'),
            last_logout: $data->string('last_logout'),
            logins: $data->integer('logins'),
        );
    }
}
