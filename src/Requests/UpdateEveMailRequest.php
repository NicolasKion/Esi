<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

class UpdateEveMailRequest extends Request implements WithBody
{

    /**
     * @param int $character_id
     * @param int $mail_id
     * @param bool $read
     * @param array|null $labels
     */
    public function __construct(public int $character_id, public int $mail_id, public bool $read = true, public ?array $labels = null)
    {
    }


    public function getBody(): mixed
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

    public function createDtoFromResponse(Response $response): mixed
    {
        return $response->json();
    }

    public function shouldRetry(Response $response): bool
    {
        return true;
    }
}
