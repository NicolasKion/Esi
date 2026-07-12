<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Request;

/**
 * @extends Request<null>
 */
class KickFleetMemberRequest extends Request
{
    public function __construct(
        public int $fleet_id,
        public int $member_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/fleets/%d/members/%d/', $this->fleet_id, $this->member_id);
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::DELETE;
    }

    public function createDto(Response $response, mixed $data): null
    {
        return null;
    }

    public function shouldRetry(Response $response): bool
    {
        return false;
    }
}
