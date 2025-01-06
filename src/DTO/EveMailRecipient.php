<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Enums\RecipientType;
use NicolasKion\Esi\Interfaces\FromArray;

readonly class EveMailRecipient implements FromArray
{
    function __construct(
        public int           $recipient_id,
        public RecipientType $recipient_type,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            recipient_id: $data['recipient_id'],
            recipient_type: RecipientType::from($data['recipient_type'])
        );
    }

    public function __serialize(): array
    {
        return [
            'recipient_id' => $this->recipient_id,
            'recipient_type' => $this->recipient_type->value,
        ];
    }
}
