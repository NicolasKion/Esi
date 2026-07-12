<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\StarbaseDetail;
use NicolasKion\Esi\Request;

/**
 * @extends Request<StarbaseDetail>
 */
class GetCorporationStarbaseRequest extends Request
{
    public function __construct(
        public int $corporation_id,
        public int $starbase_id,
        public int $system_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/starbases/%d/', $this->corporation_id, $this->starbase_id);
    }

    /**
     * @return array<string, mixed>
     */
    public function getQuery(): array
    {
        return ['system_id' => $this->system_id];
    }

    public function createDto(Response $response, mixed $data): StarbaseDetail
    {
        return StarbaseDetail::hydrate($data);
    }
}
