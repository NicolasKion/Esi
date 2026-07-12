<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\FreelanceJob;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<array<int, FreelanceJob>>
 */
class GetCorporationFreelanceJobsRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/freelance-jobs', $this->corporation_id);
    }

    /**
     * @return array<int, FreelanceJob>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return FreelanceJob::hydrateList(Data::of($data)->raw('freelance_jobs'));
    }
}
