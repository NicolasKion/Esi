<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\DogmaItem;
use NicolasKion\Esi\Request;

class GetDogmaItemAttributesRequest extends Request
{
    public function __construct(
        public int $type_id,
        public int $item_id,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/dogma/dynamic/items/%d/%d/', $this->type_id, $this->item_id);
    }

    public function createDtoFromResponse(Response $response): DogmaItem
    {
        return DogmaItem::fromArray($response->json());
    }
}
