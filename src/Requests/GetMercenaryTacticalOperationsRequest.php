<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MercenaryTacticalOperation;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<array<int, MercenaryTacticalOperation>>
 */
class GetMercenaryTacticalOperationsRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/mercenary-tactical-operations', $this->character_id);
    }

    /**
     * @return array<int, MercenaryTacticalOperation>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return MercenaryTacticalOperation::hydrateList(Data::of($data)->raw('operations'));
    }
}
