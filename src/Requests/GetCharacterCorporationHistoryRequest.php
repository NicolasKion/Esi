<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CorporationHistory;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, CorporationHistory>>
 */
class GetCharacterCorporationHistoryRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/corporationhistory/', $this->character_id);
    }

    /**
     * @return array<int, CorporationHistory>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return CorporationHistory::hydrateList($data);
    }
}
