<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Request;

/**
 * @extends Request<float>
 */
class GetWalletBalanceRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/wallet/', $this->character_id);
    }

    public function createDto(Response $response, mixed $data): float
    {
        return is_numeric($data) ? (float) $data : 0.0;
    }
}
