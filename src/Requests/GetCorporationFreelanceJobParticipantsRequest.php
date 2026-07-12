<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\FreelanceJobParticipant;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<array<int, FreelanceJobParticipant>>
 */
class GetCorporationFreelanceJobParticipantsRequest extends Request
{
    public function __construct(
        public int $corporation_id,
        public string $job_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/freelance-jobs/%s/participants', $this->corporation_id, $this->job_id);
    }

    /**
     * @return array<int, FreelanceJobParticipant>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return FreelanceJobParticipant::hydrateList(Data::of($data)->raw('participants'));
    }
}
