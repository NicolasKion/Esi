<?php

declare(strict_types=1);

namespace NicolasKion\Esi;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\EsiError;
use NicolasKion\Esi\DTO\EsiResult;
use NicolasKion\Esi\DTO\EsiStats;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\EsiToken;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Interfaces\WithPagination;
use Throwable;

use function config;

class Connector
{
    public const ERROR_LIMIT_REMAIN_HEADER = 'X-Esi-Error-Limit-Remain';

    public const ERROR_LIMIT_RESET_HEADER = 'X-Esi-Error-Limit-Reset';

    public const EXPIRES_HEADER = 'Expires';

    public ?EsiError $error = null;

    private ?EsiToken $token = null;

    public function __construct(?EsiToken $token = null)
    {
        if ($token) {
            $this->token = $token;
            $this->ensureTokenIsValid();
        }
    }

    /**
     * @template T
     *
     * @param  Request<T>  $request
     * @return EsiResult<T>
     */
    public function send(Request $request): EsiResult
    {
        if ($this->error) {
            return EsiResult::fromError($this->error);
        }

        $token = $this->token;

        $pending_request = Http::withHeaders([
            'User-Agent' => config()->string('esi.user_agent'),
            'X-Compatibility-Date' => config()->string('esi.compatibility_date'),
        ])
            ->baseUrl(config()->string('esi.base_url'))
            ->when(count($request->getQuery()), fn (PendingRequest $r) => $r->withQueryParameters($request->getQuery()))
            ->when(count($request->getHeaders()), fn (PendingRequest $r) => $r->withHeaders($request->getHeaders()))
            ->when($token !== null, fn (PendingRequest $r) => $r->withToken((string) $token?->getAccessToken()))
            ->retry(
                times: config()->integer('esi.retry_policy.tries'),
                sleepMilliseconds: config()->integer('esi.retry_policy.delay'),
                when: fn (Throwable $e, PendingRequest $pendingRequest) => $e instanceof RequestException && $request->shouldRetry($e->response),
                throw: false
            );

        $body = $request instanceof WithBody ? $this->normalizeBody($request->getBody()) : [];

        try {

            $response = match ($request->getMethod()) {
                RequestMethod::GET => $pending_request->get($request->resolveEndpoint()),
                RequestMethod::POST => $pending_request->post($request->resolveEndpoint(), $body),
                RequestMethod::PUT => $pending_request->put($request->resolveEndpoint(), $body),
                RequestMethod::DELETE => $pending_request->delete($request->resolveEndpoint()),
                RequestMethod::PATCH => $pending_request->patch($request->resolveEndpoint()),
            };

        } catch (ConnectionException $e) {
            return EsiResult::fromError(new EsiError(code: 500, body: $e->getMessage()));
        }

        if ($response->failed()) {
            return $this->handleFailedResponse($response);
        }

        return new EsiResult(
            stats: $this->getStatsFromResponse($response),
            data: $request->createDto($response, $this->normalizeJson($response)),
        );
    }

    /**
     * @template T
     *
     * @param  WithPagination<array<int, T>>  $request
     * @return EsiResult<array<int, T>>
     */
    public function sendPaginated(WithPagination $request): EsiResult
    {
        $page = 0;

        $results = [];

        $token = $this->token;

        do {
            $page++;

            $pending_request = Http::withHeaders([
                'User-Agent' => config()->string('esi.user_agent'),
                'X-Compatibility-Date' => config()->string('esi.compatibility_date'),
            ])
                ->baseUrl(config()->string('esi.base_url'))
                ->when(count($request->getQuery()), fn (PendingRequest $r) => $r->withQueryParameters($request->getQuery()))
                ->withQueryParameters(['page' => $page])
                ->when(count($request->getHeaders()), fn (PendingRequest $r) => $r->withHeaders($request->getHeaders()))
                ->when($token !== null, fn (PendingRequest $r) => $r->withToken((string) $token?->getAccessToken()))
                ->retry(
                    times: config()->integer('esi.retry_policy.tries'),
                    sleepMilliseconds: config()->integer('esi.retry_policy.delay'),
                    when: fn (Throwable $e, PendingRequest $pendingRequest) => $e instanceof RequestException && $request->shouldRetry($e->response),
                    throw: false
                );

            try {
                // Paginated endpoints are always GET.
                $response = $pending_request->get($request->resolveEndpoint());
            } catch (ConnectionException $e) {
                return EsiResult::fromError(new EsiError(code: 500, body: $e->getMessage()));
            }

            if ($response->failed()) {
                return $this->handleFailedResponse($response);
            }

            $results = array_merge($results, $request->createDto($response, $this->normalizeJson($response)));
        } while ($request->hasMorePages($page, $response));

        return new EsiResult(
            stats: $this->getStatsFromResponse($response),
            data: $results,
        );
    }

    private function ensureTokenIsValid(): void
    {
        if ($this->token !== null && $this->token->isExpired()) {
            $this->refreshToken($this->token);
        }
    }

    private function refreshToken(EsiToken $token): void
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => config('esi.user_agent'),
                'Host' => 'login.eveonline.com',
            ])
                ->asForm()
                ->withBasicAuth(config()->string('esi.client_id'), config()->string('esi.client_secret'))
                ->retry(5, 1000, fn (Throwable $e, PendingRequest $pendingRequest) => $e instanceof RequestException && $e->response->status() >= 500, throw: false)
                ->post('https://login.eveonline.com/v2/oauth/token', [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $token->getRefreshToken(),
                ]);

        } catch (ConnectionException $e) {
            $this->error = new EsiError(
                code: 500,
                body: $e->getMessage(),
            );

            return;
        }

        if ($response->failed()) {
            $token->delete();
            $this->error = new EsiError(
                code: $response->status(),
                body: $response->body(),
            );

            return;
        }

        $expires_in = $response->json('expires_in');

        $token->update([
            'access_token' => $response->json('access_token'),
            'expires_at' => now()->addSeconds(is_numeric($expires_in) ? (int) $expires_in : 0),
            'refresh_token' => $response->json('refresh_token'),
        ]);
    }

    private function getStatsFromResponse(Response $response): EsiStats
    {
        return new EsiStats(
            expires: $this->getExpiresFromResponse($response),
            errors_remaining: $this->getErrorsRemainingFromResponse($response),
            error_limit_reset: $this->getErrorLimitResetFromResponse($response),
        );
    }

    private function getExpiresFromResponse(Response $response): string
    {
        return $response->header(self::EXPIRES_HEADER);
    }

    private function getErrorsRemainingFromResponse(Response $response): int
    {
        $remain = $response->header(self::ERROR_LIMIT_REMAIN_HEADER) ?: 0;

        return (int) $remain;
    }

    private function getErrorLimitResetFromResponse(Response $response): int
    {
        $reset = $response->header(self::ERROR_LIMIT_RESET_HEADER) ?: 100;

        return (int) $reset;
    }

    private function normalizeJson(Response $response): mixed
    {
        $data = $response->json();

        if (is_array($data)) {
            return Unicode::normalizeArray($data);
        }

        if (is_string($data)) {
            return Unicode::normalize($data);
        }

        return $data;
    }

    /**
     * @return EsiResult<never>
     */
    private function handleFailedResponse(Response $response): EsiResult
    {
        if (($response->forbidden() || $response->unauthorized()) && $this->token !== null) {
            $this->token->delete();
        }

        return EsiResult::fromError(
            new EsiError(
                code: $response->status(),
                body: $response->body(),
            ),
            $this->getStatsFromResponse($response),
        );
    }

    /**
     * Coerce a request body to the array shape Laravel's HTTP client accepts.
     *
     * Request bodies in this library are always JSON objects or id lists, so
     * their keys are strings or non-negative integers.
     *
     * @return array<int<0, max>|string, mixed>
     */
    private function normalizeBody(mixed $body): array
    {
        if (! is_array($body)) {
            return [];
        }

        /** @var array<int<0, max>|string, mixed> $body */
        return $body;
    }
}
