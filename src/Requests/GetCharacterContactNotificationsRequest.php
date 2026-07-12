<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\ContactNotification;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, ContactNotification>>
 */
class GetCharacterContactNotificationsRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/notifications/contacts/', $this->character_id);
    }

    /**
     * @return array<int, ContactNotification>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return ContactNotification::hydrateList($data);
    }
}
