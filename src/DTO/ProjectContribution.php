<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * A single character's contribution to a corporation project.
 */
readonly class ProjectContribution extends Dto
{
    public function __construct(
        public int $contributed,
        public ?string $last_modified,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            contributed: $data->integer('contributed', 0),
            last_modified: $data->string('last_modified'),
        );
    }
}
