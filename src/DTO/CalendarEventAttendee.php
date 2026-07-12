<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CalendarEventAttendee extends Dto
{
    public function __construct(
        public int $character_id,
        public string $event_response,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            character_id: $data->integer('character_id', 0),
            event_response: $data->string('event_response', ''),
        );
    }
}
