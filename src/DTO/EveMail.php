<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class EveMail extends Dto
{
    /**
     * @param  array<int, int>  $labels  Label ids applied to the mail.
     * @param  array<int, EveMailRecipient>  $recipients
     */
    public function __construct(
        public ?int $mail_id,
        public int $from,
        public bool $is_read,
        public array $labels,
        public array $recipients,
        public string $subject,
        public string $timestamp,
        public ?string $body = null,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            mail_id: $data->integer('mail_id'),
            from: $data->integer('from', 0),
            is_read: $data->boolean('is_read', $data->boolean('read', false)),
            labels: $data->integers('labels'),
            recipients: $data->list('recipients', EveMailRecipient::fromData(...)),
            subject: $data->string('subject', ''),
            timestamp: $data->string('timestamp', ''),
            body: $data->string('body'),
        );
    }
}
