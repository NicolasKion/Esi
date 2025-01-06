<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\AssetName;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

class GetAssetNamesRequest extends Request implements WithBody
{
    public function __construct(
        public int   $character_id,
        public array $ids
    )
    {
        //
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/assets/names/', $this->character_id);
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
}
