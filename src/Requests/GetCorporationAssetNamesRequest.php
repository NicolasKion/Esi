<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\AssetName;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

class GetCorporationAssetNamesRequest extends Request implements WithBody
{
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

    public function createDtoFromResponse(Response $response): array
    {
        $items = [];

        foreach ($response->json() as $item) {
            $items[] = AssetName::fromArray($item);
        }

        return $items;
    }

    public function getBody(): array
    {
        return $this->ids;
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }
}
