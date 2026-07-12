<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<array<int, int>>
 */
class GetWarsRequest extends Request
{
    public function __construct(public ?int $max_war_id = null) {}

    public function resolveEndpoint(): string
    {
        return '/wars/';
    }

    /**
     * @return array<string, mixed>
     */
    public function getQuery(): array
    {
        $query = [];

        if ($this->max_war_id !== null) {
            $query['max_war_id'] = $this->max_war_id;
        }

        return $query;
    }

    /**
     * @return array<int, int>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Data::integerList($data);
    }
}
