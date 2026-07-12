<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * A character's participation status in a freelance job.
 */
readonly class FreelanceJobParticipation extends Dto
{
    public function __construct(
        public string $state,
        public int $contributed,
        public string $last_modified,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            state: $data->string('state', ''),
            contributed: $data->integer('contributed', 0),
            last_modified: $data->string('last_modified', ''),
        );
    }
}
