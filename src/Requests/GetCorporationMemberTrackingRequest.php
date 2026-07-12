<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MemberTracking;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, MemberTracking>>
 */
class GetCorporationMemberTrackingRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/membertracking/', $this->corporation_id);
    }

    /**
     * @return array<int, MemberTracking>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return MemberTracking::hydrateList($data);
    }
}
