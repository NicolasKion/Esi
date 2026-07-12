<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\AssetName;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, AssetName>>
 */
class GetCorporationAssetNamesRequest extends Request implements WithBody
{
    /**
     * @param  array<int, int>  $ids
     */
    public function __construct(
        public int $corporation_id,
        public array $ids
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/assets/names/', $this->corporation_id);
    }

    /**
     * @return array<int, AssetName>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return AssetName::hydrateList($data);
    }

    /**
     * @return array<int, int>
     */
    public function getBody(): array
    {
        return $this->ids;
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }
}
