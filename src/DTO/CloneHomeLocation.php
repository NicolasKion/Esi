<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CloneHomeLocation extends Dto
{
    public function __construct(
        public ?int $location_id,
        public ?string $location_type,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            location_id: $data->integer('location_id'),
            location_type: $data->string('location_type'),
        );
    }
}
