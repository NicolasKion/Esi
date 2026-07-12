<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MercenaryDen;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<array<int, MercenaryDen>>
 */
class GetMercenaryDensRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/structures/mercenary-dens', $this->character_id);
    }

    /**
     * @return array<int, MercenaryDen>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return MercenaryDen::hydrateList(Data::of($data)->raw('mercenary_dens'));
    }
}
