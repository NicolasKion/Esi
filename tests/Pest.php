<?php

declare(strict_types=1);

use NicolasKion\Esi\Enums\EsiScope;
use NicolasKion\Esi\Interfaces\Character;
use NicolasKion\Esi\Interfaces\EsiToken;
use NicolasKion\Esi\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

/*
|--------------------------------------------------------------------------
| Global ESI configuration
|--------------------------------------------------------------------------
|
| Every test hits the fake HTTP client, so we pin the ESI config to
| deterministic values and disable retry back-off to keep the suite fast.
|
*/
uses()->beforeEach(function (): void {
    config()->set('esi.base_url', 'https://esi.evetech.net');
    config()->set('esi.user_agent', 'esi-test');
    config()->set('esi.retry_policy.tries', 1);
    config()->set('esi.retry_policy.delay', 0);
})->in(__DIR__);

/**
 * Load a JSON fixture from tests/Fixtures as a decoded array.
 *
 * Fixtures mirror the shapes described by the ESI OpenAPI schema, so a
 * faked response built from one exercises the same DTO mapping the real
 * API would.
 *
 * @return array<mixed>
 */
function esiFixture(string $path): array
{
    $full = __DIR__.'/Fixtures/'.mb_ltrim($path, '/');

    if (! is_file($full)) {
        throw new RuntimeException("Fixture not found: {$path}");
    }

    /** @var array<mixed> $decoded */
    $decoded = json_decode((string) file_get_contents($full), true, 512, JSON_THROW_ON_ERROR);

    return $decoded;
}

/**
 * Build a fake authenticated Character with a non-expiring token.
 *
 * Used by tests that exercise authenticated endpoints. The character id
 * defaults to 123 and the corporation id to 456 so faked URLs are stable.
 */
function fakeCharacter(int $id = 123, int $corporationId = 456): Character
{
    $token = new class implements EsiToken
    {
        public function isExpired(): bool
        {
            return false;
        }

        public function getRefreshToken(): string
        {
            return 'refresh';
        }

        public function getAccessToken(): string
        {
            return 'access';
        }

        public function delete(): mixed
        {
            return null;
        }

        public function update(array $data): mixed
        {
            return null;
        }
    };

    return new class($token, $id, $corporationId) implements Character
    {
        public function __construct(
            private EsiToken $token,
            private int $id,
            private int $corporationId,
        ) {}

        public function getEsiTokenWithScope(EsiScope $scope): ?EsiToken
        {
            return $this->token;
        }

        public function getId(): int
        {
            return $this->id;
        }

        public function getCorporationId(): int
        {
            return $this->corporationId;
        }
    };
}

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

        public function delete(): mixed
        {
            $this->deleted = true;

            return null;
        }

        public function update(array $data): mixed
        {
            $this->updated = $data;
            $this->expired = false;

            return null;
        }
    };
}

/**
 * Wrap a token in a Character that hands it back for any requested scope.
 */
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
