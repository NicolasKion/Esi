<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

/**
 * @extends Request<null>
 */
class MoveFleetMemberRequest extends Request implements WithBody
{
    public function __construct(
        public int $fleet_id,
        public int $member_id,
        public string $role,
        public ?int $squad_id = null,
        public ?int $wing_id = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function getBody(): array
    {
        $data = [
            'role' => $this->role,
        ];

        if ($this->squad_id !== null) {
            $data['squad_id'] = $this->squad_id;
        }

        if ($this->wing_id !== null) {
            $data['wing_id'] = $this->wing_id;
        }

        return $data;
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/fleets/%d/members/%d/', $this->fleet_id, $this->member_id);
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::PUT;
    }

    public function createDto(Response $response, mixed $data): null
    {
        return null;
    }

    public function shouldRetry(Response $response): bool
    {
        return true;
    }
}
