<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Enums\ContactType;
use NicolasKion\Esi\Interfaces\FromArray;

readonly class Contact implements FromArray
{
    /**
     * @param  int[]  $label_ids
     */
    public function __construct(
        public int $contact_id,
        public ContactType $contact_type,
        public float $standing,
        public ?bool $is_watched,
        public ?bool $is_blocked,
        public array $label_ids,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            contact_id: $data['contact_id'],
            contact_type: ContactType::from($data['contact_type']),
            standing: (float) $data['standing'],
            is_watched: $data['is_watched'] ?? null,
            is_blocked: $data['is_blocked'] ?? null,
            label_ids: $data['label_ids'] ?? [],
        );
    }
}
