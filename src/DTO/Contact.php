<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Enums\ContactType;
use NicolasKion\Esi\Support\Data;

readonly class Contact extends Dto
{
    /**
     * @param  array<int, int>  $label_ids
     */
    public function __construct(
        public int $contact_id,
        public ContactType $contact_type,
        public float $standing,
        public ?bool $is_watched,
        public ?bool $is_blocked,
        public array $label_ids,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            contact_id: $data->integer('contact_id', 0),
            contact_type: ContactType::from($data->string('contact_type', '')),
            standing: $data->float('standing', 0.0),
            is_watched: $data->boolean('is_watched'),
            is_blocked: $data->boolean('is_blocked'),
            label_ids: $data->integers('label_ids'),
        );
    }
}
