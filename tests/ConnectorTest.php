<?php

declare(strict_types=1);

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\Connector;
use NicolasKion\Esi\Enums\EsiScope;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Esi;
use NicolasKion\Esi\Interfaces\Character;
use NicolasKion\Esi\Interfaces\EsiToken;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

/**
 * A token whose expiry, updates and deletion are observable from the test.
 */
function trackedToken(bool $expired = false): EsiToken
{
    return new class($expired) implements EsiToken
    {
        /** @var array<string, mixed> */
        public array $updated = [];

        public bool $deleted = false;

        public function __construct(private bool $expired) {}

        public function isExpired(): bool
        {
            return $this->expired;
        }

        public function getRefreshToken(): string
        {
            return 'refresh-token';
        }

        public function getAccessToken(): string
        {
            return 'access-token';
        }

        public function delete(): void
        {
            $this->deleted = true;
        }

        public function update(array $data): void
        {
            $this->updated = $data;
            $this->expired = false;
        }
    };
}

function characterFor(EsiToken $token): Character
{
    return new class($token) implements Character
    {
        public function __construct(private EsiToken $token) {}

        public function getEsiTokenWithScope(EsiScope $scope): ?EsiToken
        {
            return $this->token;
        }

        public function getId(): int
        {
            return 123;
        }

        public function getCorporationId(): int
        {
            return 456;
        }
    };
}

beforeEach(function (): void {
    config()->set('esi.client_id', 'client-id');
    config()->set('esi.client_secret', 'client-secret');
});

it('refreshes an expired token before sending the request', function (): void {
    $token = trackedToken(expired: true);

    Http::fake([
        'login.eveonline.com/*' => Http::response([
            'access_token' => 'fresh-access',
            'expires_in' => 1200,
            'refresh_token' => 'fresh-refresh',
        ]),
        'esi.evetech.net/characters/123/online/*' => Http::response(['online' => true]),
    ]);

    $result = (new Esi)->getOnline(characterFor($token));

    expect($result->wasSuccessful())->toBeTrue()
        ->and($token->updated['access_token'])->toBe('fresh-access')
        ->and($token->updated['refresh_token'])->toBe('fresh-refresh');
});

it('deletes the token and errors when the refresh fails', function (): void {
    $token = trackedToken(expired: true);

    Http::fake([
        'login.eveonline.com/*' => Http::response(['error' => 'invalid_grant'], 400),
    ]);

    $result = (new Esi)->getOnline(characterFor($token));

    expect($result->failed())->toBeTrue()
        ->and($token->deleted)->toBeTrue();
});

it('errors with a 500 when the token endpoint is unreachable', function (): void {
    $token = trackedToken(expired: true);

    Http::fake([
        'login.eveonline.com/*' => fn () => throw new ConnectionException('login unreachable'),
    ]);

    $result = (new Esi)->getOnline(characterFor($token));

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('deletes the token on a forbidden ESI response', function (): void {
    $token = trackedToken(expired: false);

    Http::fake([
        'esi.evetech.net/characters/123/online/*' => Http::response('forbidden', 403),
    ]);

    $result = (new Esi)->getOnline(characterFor($token));

    expect($result->failed())->toBeTrue()
        ->and($token->deleted)->toBeTrue();
});

it('follows pagination across multiple pages', function (): void {
    Http::fakeSequence('esi.evetech.net/alliances/*')
        ->push([1, 2], 200, ['X-Pages' => '2'])
        ->push([3, 4], 200, ['X-Pages' => '2']);

    $result = (new Esi)->getAlliances();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([1, 2, 3, 4]);
});

it('normalizes string response bodies', function (): void {
    Http::fake([
        'esi.evetech.net/status*' => Http::response('"tranquility"', 200),
    ]);

    $result = (new Esi)->getStatus();

    expect($result->wasSuccessful())->toBeTrue();
});

it('returns a 500 error result when the ESI request throws a connection exception', function (): void {
    Http::fake([
        'esi.evetech.net/status*' => fn () => throw new ConnectionException('esi unreachable'),
    ]);

    $result = (new Esi)->getStatus();

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('errors when a paginated request throws a connection exception', function (): void {
    Http::fake([
        'esi.evetech.net/alliances/*' => fn () => throw new ConnectionException('alliances unreachable'),
    ]);

    $result = (new Esi)->getAlliances();

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('sends PATCH requests and tolerates non-array bodies', function (): void {
    Http::fake([
        'esi.evetech.net/patch-me*' => Http::response(['ok' => true]),
    ]);

    $request = new class extends Request implements WithBody
    {
        public function resolveEndpoint(): string
        {
            return '/patch-me/';
        }

        public function getMethod(): RequestMethod
        {
            return RequestMethod::PATCH;
        }

        public function getBody(): mixed
        {
            return 'not-an-array';
        }

        public function createDto(Response $response, mixed $data): null
        {
            return null;
        }
    };

    $result = (new Connector)->send($request);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($r) => $r->method() === 'PATCH');
});
