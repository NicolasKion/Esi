<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

/**
 * @extends Request<null>
 */
class RespondToCalendarEventRequest extends Request implements WithBody
{
    public function __construct(
        public int $character_id,
        public int $event_id,
        public string $response,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function getBody(): array
    {
        return [
            'response' => $this->response,
        ];
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/calendar/%d/', $this->character_id, $this->event_id);
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::PUT;
    }

    public function createDto(Response $response, mixed $data): null
    {
        return null;
    }

    public function shouldRetry(Response $response): bool
    {
        return true;
    }
}
