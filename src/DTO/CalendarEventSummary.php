<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CalendarEventSummary extends Dto
{
    public function __construct(
        public string $event_date,
        public int $event_id,
        public string $event_response,
        public int $importance,
        public string $title,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            event_date: $data->string('event_date', ''),
            event_id: $data->integer('event_id', 0),
            event_response: $data->string('event_response', ''),
            importance: $data->integer('importance', 0),
            title: $data->string('title', ''),
        );
    }
}
