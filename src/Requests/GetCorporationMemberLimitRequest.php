<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Request;

/**
 * @extends Request<int>
 */
class GetCorporationMemberLimitRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/members/limit/', $this->corporation_id);
    }

    public function createDto(Response $response, mixed $data): int
    {
        return is_numeric($data) ? (int) $data : 0;
    }
}
