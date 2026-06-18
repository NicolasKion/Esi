<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class ContactLabel implements FromArray
{
    public function __construct(
        public int $label_id,
        public string $label_name,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            label_id: $data['label_id'],
            label_name: $data['label_name'],
        );
    }
}
