<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CalendarEvent;
use NicolasKion\Esi\Request;

/**
 * @extends Request<CalendarEvent>
 */
class GetCalendarEventRequest extends Request
{
    public function __construct(public int $character_id, public int $event_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/calendar/%d/', $this->character_id, $this->event_id);
    }

    public function createDto(Response $response, mixed $data): CalendarEvent
    {
        return CalendarEvent::hydrate($data);
    }
}
