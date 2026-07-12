<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\IndustryJob;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, IndustryJob>>
 */
class GetCharacterIndustryJobsRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/industry/jobs', $this->character_id);
    }

    /**
     * @return array<int, IndustryJob>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return IndustryJob::hydrateList($data);
    }
}
