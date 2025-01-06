<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Structure;
use NicolasKion\Esi\Request;

class GetStructureRequest extends Request
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $structure_id,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/universe/structures/%d/', $this->structure_id);
    }

    public function createDtoFromResponse(Response $response): Structure
    {
        return Structure::fromArray($response->json());
    }
}
