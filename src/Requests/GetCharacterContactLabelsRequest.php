<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\ContactLabel;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, ContactLabel>>
 */
class GetCharacterContactLabelsRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/contacts/labels/', $this->character_id);
    }

    /**
     * @return array<int, ContactLabel>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return ContactLabel::hydrateList($data);
    }
}
