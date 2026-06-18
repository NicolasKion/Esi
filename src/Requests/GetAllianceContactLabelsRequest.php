<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\ContactLabel;
use NicolasKion\Esi\Request;

class GetAllianceContactLabelsRequest extends Request
{
    public function __construct(public int $alliance_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/alliances/%d/contacts/labels/', $this->alliance_id);
    }

    public function createDto(Response $response, mixed $data): array
    {
        return array_map(ContactLabel::fromArray(...), $data);
    }
}
