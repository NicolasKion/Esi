<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CalendarEventSummary;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, CalendarEventSummary>>
 */
class GetCalendarRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/calendar/', $this->character_id);
    }

    /**
     * @return array<int, CalendarEventSummary>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return CalendarEventSummary::hydrateList($data);
    }
}
