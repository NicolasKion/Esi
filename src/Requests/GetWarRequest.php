<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\War;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Request;

class GetWarRequest extends Request
{
    public function __construct(public int $war_id) {}

    public function getMethod(): RequestMethod
    {
        return RequestMethod::GET;
    }

    public function resolveEndpoint(): string
    {
        return sprintf('wars/%d', $this->war_id);
    }

    public function createDtoFromResponse(Response $response): War
    {
        return War::fromArray($response->json());
    }
}
