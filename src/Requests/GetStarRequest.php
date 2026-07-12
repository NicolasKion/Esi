<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Star;
use NicolasKion\Esi\Request;

/**
 * @extends Request<Star>
 */
class GetStarRequest extends Request
{
    public function __construct(public int $star_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/universe/stars/%d/', $this->star_id);
    }

    public function createDto(Response $response, mixed $data): Star
    {
        return Star::hydrate($data);
    }
}
