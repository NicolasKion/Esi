<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\AssetLocation;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, AssetLocation>>
 */
class GetCorporationAssetLocationsRequest extends Request implements WithBody
{
    /**
     * @param  array<int, int>  $item_ids
     */
    public function __construct(
        public int $corporation_id,
        public array $item_ids
    ) {
        //
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/assets/locations/', $this->corporation_id);
    }

    /**
     * @return array<int, AssetLocation>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return AssetLocation::hydrateList($data);
    }

    /**
     * @return array<int, int>
     */
    public function getBody(): array
    {
        return $this->item_ids;
    }
}
