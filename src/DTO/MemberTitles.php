<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class MemberTitles extends Dto
{
    /**
     * @param  array<int, int>  $titles
     */
    public function __construct(
        public int $character_id,
        public array $titles,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            character_id: $data->integer('character_id', 0),
            titles: $data->integers('titles'),
        );
    }
}
