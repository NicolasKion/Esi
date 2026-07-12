<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\FreelanceJob;
use NicolasKion\Esi\Request;

/**
 * @extends Request<FreelanceJob>
 */
class GetFreelanceJobRequest extends Request
{
    public function __construct(public string $job_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/freelance-jobs/%s', $this->job_id);
    }

    public function createDto(Response $response, mixed $data): FreelanceJob
    {
        return FreelanceJob::hydrate($data);
    }
}
