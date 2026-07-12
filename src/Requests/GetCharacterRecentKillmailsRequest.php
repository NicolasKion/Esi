<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\KillmailRef;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, KillmailRef>>
 *
 * @implements WithPagination<array<int, KillmailRef>>
 */
class GetCharacterRecentKillmailsRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/killmails/recent/', $this->character_id);
    }

    /**
     * @return array<int, KillmailRef>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return KillmailRef::hydrateList($data);
    }
}
