<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class ContactLabel extends Dto
{
    public function __construct(
        public int $label_id,
        public string $label_name,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            label_id: $data->integer('label_id', 0),
            label_name: $data->string('label_name', ''),
        );
    }
}
