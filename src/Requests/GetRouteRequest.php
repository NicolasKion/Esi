<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Enums\RoutePreference;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<array<int, int>>
 */
class GetRouteRequest extends Request implements WithBody
{
    /**
     * @param  array<int, int>  $avoid_systems
     */
    public function __construct(
        public int $origin_system_id,
        public int $destination_system_id,
        public RoutePreference $preference,
        public array $avoid_systems,
        public int $security_penalty,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/route/%d/%d', $this->origin_system_id, $this->destination_system_id);
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    /**
     * @return array<string, mixed>
     */
    public function getBody(): mixed
    {
        return [
            'preference' => $this->preference->value,
            'avoid_systems' => $this->avoid_systems,
            'security_penalty' => $this->security_penalty,
        ];
    }

    /**
     * @return array<int, int>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Data::integerList(Data::of($data)->raw('route'));
    }
}
