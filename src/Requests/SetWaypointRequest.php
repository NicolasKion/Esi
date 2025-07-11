<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Request;

class SetWaypointRequest extends Request
{
    public function __construct(
        public int $character_id,
        public int $destination_id,
        public bool $add_to_beginning = false,
        public bool $clear_other_waypoints = false,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/ui/autopilot/waypoint';
    }

    public function getQuery(): array
    {
        return [
            'destination_id' => $this->destination_id,
            'add_to_beginning' => $this->add_to_beginning,
            'clear_other_waypoints' => $this->clear_other_waypoints,
        ];
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    public function createDtoFromResponse(Response $response): int
    {
        return $response->json();
    }

    public function shouldRetry(Response $response): bool
    {
        return false;
    }
}
