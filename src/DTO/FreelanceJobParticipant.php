<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * A participant in a corporation's freelance job.
 */
readonly class FreelanceJobParticipant extends Dto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $state,
        public int $contributed,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            id: $data->integer('id', 0),
            name: $data->string('name', ''),
            state: $data->string('state', ''),
            contributed: $data->integer('contributed', 0),
        );
    }
}
