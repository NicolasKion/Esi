<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class JumpClone extends Dto
{
    /**
     * @param  array<int, int>  $implants
     */
    public function __construct(
        public int $jump_clone_id,
        public int $location_id,
        public string $location_type,
        public array $implants,
        public ?string $name,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            jump_clone_id: $data->integer('jump_clone_id', 0),
            location_id: $data->integer('location_id', 0),
            location_type: $data->string('location_type', ''),
            implants: $data->integers('implants'),
            name: $data->string('name'),
        );
    }
}
