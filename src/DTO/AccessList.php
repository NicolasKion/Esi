<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * An access list, either as returned by the listing endpoint (`id` only) or
 * the detail endpoint (which additionally reports `name`, `description` and
 * `membership`). Fields only present on the detail response are nullable.
 */
readonly class AccessList extends Dto
{
    public function __construct(
        public int $id,
        public ?string $name,
        public ?string $description,
        public ?AccessListMembership $membership,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            id: $data->integer('id', 0),
            name: $data->string('name'),
            description: $data->string('description'),
            membership: $data->has('membership') ? AccessListMembership::fromData($data->object('membership')) : null,
        );
    }
}
