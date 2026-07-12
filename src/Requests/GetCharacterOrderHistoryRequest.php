<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\PersonalMarketOrderHistory;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, PersonalMarketOrderHistory>>
 *
 * @implements WithPagination<array<int, PersonalMarketOrderHistory>>
 */
class GetCharacterOrderHistoryRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/orders/history/', $this->character_id);
    }

    /**
     * @return array<int, PersonalMarketOrderHistory>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return PersonalMarketOrderHistory::hydrateList($data);
    }
}
