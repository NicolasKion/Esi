<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Enums\RecipientType;
use NicolasKion\Esi\Support\Data;

readonly class EveMailRecipient extends Dto
{
    public function __construct(
        public int $recipient_id,
        public RecipientType $recipient_type,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function __serialize(): array
    {
        return [
            'recipient_id' => $this->recipient_id,
            'recipient_type' => $this->recipient_type->value,
        ];
    }

    public static function fromData(Data $data): self
    {
        return new self(
            recipient_id: $data->integer('recipient_id', 0),
            recipient_type: RecipientType::from($data->string('recipient_type', '')),
        );
    }
}
