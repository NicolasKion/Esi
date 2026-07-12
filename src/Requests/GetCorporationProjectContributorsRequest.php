<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\ProjectContributor;
use NicolasKion\Esi\Interfaces\WithCursorPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<array<int, ProjectContributor>>
 *
 * @implements WithCursorPagination<array<int, ProjectContributor>>
 */
class GetCorporationProjectContributorsRequest extends Request implements WithCursorPagination
{
    public function __construct(
        public int $corporation_id,
        public string $project_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/projects/%s/contributors', $this->corporation_id, $this->project_id);
    }

    /**
     * @return array<int, ProjectContributor>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return ProjectContributor::hydrateList(Data::of($data)->raw('contributors'));
    }
}
