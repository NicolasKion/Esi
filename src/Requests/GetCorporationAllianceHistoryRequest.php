<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\AllianceHistory;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, AllianceHistory>>
 */
class GetCorporationAllianceHistoryRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/alliancehistory/', $this->corporation_id);
    }

    /**
     * @return array<int, AllianceHistory>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return AllianceHistory::hydrateList($data);
    }
}
