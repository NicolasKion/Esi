<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\ProjectContribution;
use NicolasKion\Esi\Request;

/**
 * @extends Request<ProjectContribution>
 */
class GetCorporationProjectContributionRequest extends Request
{
    public function __construct(
        public int $corporation_id,
        public string $project_id,
        public int $character_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/projects/%s/contribution/%d', $this->corporation_id, $this->project_id, $this->character_id);
    }

    public function createDto(Response $response, mixed $data): ProjectContribution
    {
        return ProjectContribution::hydrate($data);
    }
}
