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
class UpdateEveMailRequest extends Request implements WithBody
{
    /**
     * @param  array<int, int>|null  $labels
     */
    public function __construct(public int $character_id, public int $mail_id, public bool $read = true, public ?array $labels = null) {}

    /**
     * @return array<string, mixed>
     */
    public function getBody(): array
    {
        $data = [
            'read' => $this->read,
        ];

        if ($this->labels !== null) {
            $data['labels'] = $this->labels;
        }

        return $data;
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/mail/%d/', $this->character_id, $this->mail_id);
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
