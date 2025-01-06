<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Enums\RecipientType;
use NicolasKion\Esi\Interfaces\FromArray;

readonly class EveMail implements FromArray
{
    function __construct(
        public ?int    $mail_id,
        public int     $from,
        public bool    $is_read,
        public array   $labels,
        public array   $recipients,
        public string  $subject,
        public string  $timestamp,
        public ?string $body = null,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        $recipients = collect($data['recipients'])->map(fn($recipient) => new EveMailRecipient(
            recipient_id: $recipient['recipient_id'],
            recipient_type: RecipientType::from($recipient['recipient_type'])
        ));

        return new self(
            mail_id: $data['mail_id'] ?? null,
            from: $data['from'],
            is_read: $data['is_read'] ?? $data['read'] ?? false,
            labels: $data['labels'],
            recipients: $recipients->toArray(),
            subject: $data['subject'],
            timestamp: $data['timestamp'],
            body: $data['body'] ?? null,
        );
    }
}
