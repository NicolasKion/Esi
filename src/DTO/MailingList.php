<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class MailingList extends Dto
{
    public function __construct(
        public int $mailing_list_id,
        public string $name,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            mailing_list_id: $data->integer('mailing_list_id', 0),
            name: $data->string('name', ''),
        );
    }
}
