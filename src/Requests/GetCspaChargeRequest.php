<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

/**
 * @extends Request<float>
 */
class GetCspaChargeRequest extends Request implements WithBody
{
    /**
     * @param  array<int, int>  $character_ids
     */
    public function __construct(public int $character_id, public array $character_ids) {}

    /**
     * @return array<int, int>
     */
    public function getBody(): array
    {
        return $this->character_ids;
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/cspa/', $this->character_id);
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    public function createDto(Response $response, mixed $data): float
    {
        return is_numeric($data) ? (float) $data : 0.0;
    }
}
