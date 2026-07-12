<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\PersonalMarketOrder;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, PersonalMarketOrder>>
 */
class GetCharacterOrdersRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/orders/', $this->character_id);
    }

    /**
     * @return array<int, PersonalMarketOrder>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return PersonalMarketOrder::hydrateList($data);
    }
}
