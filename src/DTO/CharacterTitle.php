<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CharacterTitle extends Dto
{
    public function __construct(
        public ?string $name,
        public ?int $title_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            name: $data->string('name'),
            title_id: $data->integer('title_id'),
        );
    }
}
