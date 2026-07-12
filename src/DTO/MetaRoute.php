<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * The health status of a single ESI route.
 */
readonly class MetaRoute extends Dto
{
    public function __construct(
        public string $method,
        public string $path,
        public string $status,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            method: $data->string('method', ''),
            path: $data->string('path', ''),
            status: $data->string('status', ''),
        );
    }
}
