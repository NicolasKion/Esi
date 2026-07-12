<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class ContactNotification extends Dto
{
    public function __construct(
        public string $message,
        public int $notification_id,
        public string $send_date,
        public int $sender_character_id,
        public float $standing_level,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            message: $data->string('message', ''),
            notification_id: $data->integer('notification_id', 0),
            send_date: $data->string('send_date', ''),
            sender_character_id: $data->integer('sender_character_id', 0),
            standing_level: $data->float('standing_level', 0.0),
        );
    }
}
