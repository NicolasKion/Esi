<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\EveMailRecipient;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

class SendMailRequest extends Request implements WithBody
{

    /**
     * @param int $sender_id
     * @param EveMailRecipient[] $recipients
     * @param string $subject
     * @param string $body
     */
    public function __construct(public int $sender_id, public array $recipients, public string $subject, public string $body)
    {
    }


    public function getBody(): mixed
    {
        return [
            'approved_cost' => 0,
            'body' => $this->body,
            'recipients' => $this->recipients,
            'subject' => $this->subject,
        ];
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/mail/', $this->sender_id);
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    public function createDtoFromResponse(Response $response): int
    {
        return $response->json();
    }

    public function shouldRetry(Response $response): bool
    {
        return false;
    }
}
