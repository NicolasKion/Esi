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
class GetCharacterFreelanceJobsRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/freelance-jobs', $this->character_id);
    }

    /**
     * @return array<int, FreelanceJob>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return FreelanceJob::hydrateList(Data::of($data)->raw('freelance_jobs'));
    }
}
