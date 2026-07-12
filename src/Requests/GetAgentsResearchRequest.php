<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\AgentResearch;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, AgentResearch>>
 */
class GetAgentsResearchRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/agents_research/', $this->character_id);
    }

    /**
     * @return array<int, AgentResearch>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return AgentResearch::hydrateList($data);
    }
}
