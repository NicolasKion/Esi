<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\SkillQueueEntry;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, SkillQueueEntry>>
 */
class GetCharacterSkillQueueRequest extends Request
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $character_id
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/skillqueue/', $this->character_id);
    }

    /**
     * @return array<int, SkillQueueEntry>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return SkillQueueEntry::hydrateList($data);
    }
}
