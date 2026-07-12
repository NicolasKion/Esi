<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CalendarEvent extends Dto
{
    public function __construct(
        public string $date,
        public int $duration,
        public int $event_id,
        public int $importance,
        public int $owner_id,
        public string $owner_name,
        public string $owner_type,
        public string $response,
        public string $text,
        public string $title,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            date: $data->string('date', ''),
            duration: $data->integer('duration', 0),
            event_id: $data->integer('event_id', 0),
            importance: $data->integer('importance', 0),
            owner_id: $data->integer('owner_id', 0),
            owner_name: $data->string('owner_name', ''),
            owner_type: $data->string('owner_type', ''),
            response: $data->string('response', ''),
            text: $data->string('text', ''),
            title: $data->string('title', ''),
        );
    }
}
