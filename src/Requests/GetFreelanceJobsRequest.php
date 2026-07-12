<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\FreelanceJob;
use NicolasKion\Esi\Interfaces\WithCursorPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<array<int, FreelanceJob>>
 *
 * @implements WithCursorPagination<array<int, FreelanceJob>>
 */
class GetFreelanceJobsRequest extends Request implements WithCursorPagination
{
    public function resolveEndpoint(): string
    {
        return '/freelance-jobs';
    }

    /**
     * @return array<int, FreelanceJob>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return FreelanceJob::hydrateList(Data::of($data)->raw('freelance_jobs'));
    }
}
