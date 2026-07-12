<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Notification;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, Notification>>
 */
class GetCharacterNotificationsRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/notifications/', $this->character_id);
    }

    /**
     * @return array<int, Notification>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Notification::hydrateList($data);
    }
}
