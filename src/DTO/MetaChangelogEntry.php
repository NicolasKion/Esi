<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * A single changelog entry for a route, keyed by date in {@see MetaChangelog}.
 */
readonly class MetaChangelogEntry extends Dto
{
    public function __construct(
        public string $method,
        public string $path,
        public string $compatibility_date,
        public string $type,
        public string $description,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            method: $data->string('method', ''),
            path: $data->string('path', ''),
            compatibility_date: $data->string('compatibility_date', ''),
            type: $data->string('type', ''),
            description: $data->string('description', ''),
        );
    }
}
