<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CharacterAffiliation;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

class GetAffiliationsRequest extends Request implements WithBody
{
    /**
     * @param array<int> $ids
     */
    function __construct(public array $ids)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/characters/affiliation/';
    }

    public function getBody(): array
    {
        return $this->ids;
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    public function createDtoFromResponse(Response $response): array
    {
        $affiliations = [];

        foreach ($response->json() as $affiliation) {
            $affiliations[] = CharacterAffiliation::fromArray($affiliation);
        }

        return $affiliations;
    }
}
