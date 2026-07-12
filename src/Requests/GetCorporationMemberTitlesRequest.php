<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MemberTitles;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, MemberTitles>>
 */
class GetCorporationMemberTitlesRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/members/titles/', $this->corporation_id);
    }

    /**
     * @return array<int, MemberTitles>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return MemberTitles::hydrateList($data);
    }
}
