<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<array<int, int>>
 */
class GetCorporationMembersRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/members/', $this->corporation_id);
    }

    /**
     * @return array<int, int>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Data::integerList($data);
    }
}
