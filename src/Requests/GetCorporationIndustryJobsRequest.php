<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\IndustryJob;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, IndustryJob>>
 *
 * @implements WithPagination<array<int, IndustryJob>>
 */
class GetCorporationIndustryJobsRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/industry/jobs', $this->corporation_id);
    }

    /**
     * @return array<int, IndustryJob>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return IndustryJob::hydrateList($data);
    }
}
