<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Request;

/**
 * @extends Request<null>
 */
class OpenMarketDetailsWindowRequest extends Request
{
    public function __construct(public int $type_id) {}

    public function resolveEndpoint(): string
    {
        return '/ui/openwindow/marketdetails/';
    }

    /**
     * @return array<string, mixed>
     */
    public function getQuery(): array
    {
        return [
            'type_id' => $this->type_id,
        ];
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    public function createDto(Response $response, mixed $data): null
    {
        return null;
    }
}
