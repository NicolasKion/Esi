<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CalendarEventAttendee;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, CalendarEventAttendee>>
 */
class GetCalendarEventAttendeesRequest extends Request
{
    public function __construct(public int $character_id, public int $event_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/calendar/%d/attendees/', $this->character_id, $this->event_id);
    }

    /**
     * @return array<int, CalendarEventAttendee>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return CalendarEventAttendee::hydrateList($data);
    }
}
