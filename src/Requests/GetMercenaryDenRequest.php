<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MercenaryDen;
use NicolasKion\Esi\Request;

/**
 * @extends Request<MercenaryDen>
 */
class GetMercenaryDenRequest extends Request
{
    public function __construct(
        public int $character_id,
        public int $mercenary_den_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/structures/mercenary-dens/%d', $this->character_id, $this->mercenary_den_id);
    }

    public function createDto(Response $response, mixed $data): MercenaryDen
    {
        return MercenaryDen::hydrate($data);
    }
}
