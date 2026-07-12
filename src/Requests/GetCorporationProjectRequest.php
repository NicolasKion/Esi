<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CorporationProject;
use NicolasKion\Esi\Request;

/**
 * @extends Request<CorporationProject>
 */
class GetCorporationProjectRequest extends Request
{
    public function __construct(
        public int $corporation_id,
        public string $project_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/projects/%s', $this->corporation_id, $this->project_id);
    }

    public function createDto(Response $response, mixed $data): CorporationProject
    {
        return CorporationProject::hydrate($data);
    }
}
