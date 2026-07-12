<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\FreelanceJobParticipation;
use NicolasKion\Esi\Request;

/**
 * @extends Request<FreelanceJobParticipation>
 */
class GetCharacterFreelanceJobParticipationRequest extends Request
{
    public function __construct(
        public int $character_id,
        public string $job_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/freelance-jobs/%s/participation', $this->character_id, $this->job_id);
    }

    public function createDto(Response $response, mixed $data): FreelanceJobParticipation
    {
        return FreelanceJobParticipation::hydrate($data);
    }
}
