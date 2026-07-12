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
class OpenNewMailWindowRequest extends Request implements WithBody
{
    /**
     * @param  array<int, int>  $recipients
     */
    public function __construct(
        public array $recipients,
        public string $subject,
        public string $body,
        public ?int $to_corp_or_alliance_id = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function getBody(): array
    {
        $data = [
            'body' => $this->body,
            'recipients' => $this->recipients,
            'subject' => $this->subject,
        ];

        if ($this->to_corp_or_alliance_id !== null) {
            $data['to_corp_or_alliance_id'] = $this->to_corp_or_alliance_id;
        }

        return $data;
    }

    public function resolveEndpoint(): string
    {
        return '/ui/openwindow/newmail/';
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    public function createDto(Response $response, mixed $data): null
    {
        return null;
    }
}
