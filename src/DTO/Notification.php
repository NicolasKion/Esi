<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Notification extends Dto
{
    public function __construct(
        public ?bool $is_read,
        public int $notification_id,
        public int $sender_id,
        public string $sender_type,
        public ?string $text,
        public string $timestamp,
        public string $type,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            is_read: $data->boolean('is_read'),
            notification_id: $data->integer('notification_id', 0),
            sender_id: $data->integer('sender_id', 0),
            sender_type: $data->string('sender_type', ''),
            text: $data->string('text'),
            timestamp: $data->string('timestamp', ''),
            type: $data->string('type', ''),
        );
    }
}
