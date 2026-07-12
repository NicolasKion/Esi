<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\ContactLabel;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, ContactLabel>>
 */
class GetCorporationContactLabelsRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/contacts/labels/', $this->corporation_id);
    }

    /**
     * @return array<int, ContactLabel>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return ContactLabel::hydrateList($data);
    }
}
