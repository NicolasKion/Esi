<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\ContainerLog;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, ContainerLog>>
 *
 * @implements WithPagination<array<int, ContainerLog>>
 */
class GetCorporationContainerLogsRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/containers/logs/', $this->corporation_id);
    }

    /**
     * @return array<int, ContainerLog>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return ContainerLog::hydrateList($data);
    }
}
