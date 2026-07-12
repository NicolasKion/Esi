<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class MailLabel extends Dto
{
    public function __construct(
        public int $label_id,
        public ?string $name,
        public ?string $color,
        public ?int $unread_count,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            label_id: $data->integer('label_id', 0),
            name: $data->string('name'),
            color: $data->string('color'),
            unread_count: $data->integer('unread_count'),
        );
    }
}
