<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Request;

class OpenContractRequest extends Request
{
    public function __construct(public int $contract_id) {}

    public function resolveEndpoint(): string
    {
        return '/ui/openwindow/contract/';
    }

    public function getQuery(): array
    {
        return [
            'contract_id' => $this->contract_id,
        ];
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    public function createDtoFromResponse(Response $response): null
    {
        return null;
    }
}
