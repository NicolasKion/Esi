<?php

declare(strict_types=1);

namespace NicolasKion\Esi;

use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\EsiError;
use NicolasKion\Esi\DTO\EsiResult;
use NicolasKion\Esi\DTO\EsiStats;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\EsiToken;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Interfaces\WithPagination;

class Connector
{
    const ERROR_LIMIT_REMAIN_HEADER = 'X-Esi-Error-Limit-Remain';

    const ERROR_LIMIT_RESET_HEADER = 'X-Esi-Error-Limit-Reset';

    const EXPIRES_HEADER = 'Expires';

    public ?EsiError $error = null;

    private ?EsiToken $token = null;

    /**
     * @throws ConnectionException
     */
    public function __construct(?EsiToken $token = null)
    {
        if ($token) {
            $this->token = $token;
            $this->ensureTokenIsValid();
        }
    }

    /**
     * @throws ConnectionException
     */
    private function ensureTokenIsValid(): void
    {
        if ($this->token->isExpired()) {
            $this->refreshToken();
        }
    }

    /**
     * @throws ConnectionException
     */
    private function refreshToken(): void
    {
        $response = Http::withHeaders([
            'User-Agent' => config('esi.user_agent'),
            'Host' => 'login.eveonline.com',
        ])
            ->asForm()
            ->withBasicAuth(config('esi.client_id'), config('esi.client_secret'))
            ->retry(5, 1000, fn (Exception $response) => $response->response?->status() >= 500, throw: false)
            ->post('https://login.eveonline.com/v2/oauth/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $this->token->getRefreshToken(),
            ]);

        if ($response->failed()) {
            $this->token->delete();
            $this->error = new EsiError(
                code: $response->status(),
                body: $response->body(),
            );

            return;
        }

        $this->token->update([
            'access_token' => $response->json('access_token'),
            'expires_at' => now()->addSeconds($response->json('expires_in')),
            'refresh_token' => $response->json('refresh_token'),
        ]);
    }

    /**
     * @throws ConnectionException
     */
    public function send(Request $request): EsiResult
    {
        if ($this->error) {
            return new EsiResult(
                error: $this->error,
            );
        }

        $pending_request = Http::withHeaders([
            'User-Agent' => config('esi.user_agent'),
        ])
            ->baseUrl('https://esi.evetech.net/latest')
            ->when(count($request->getQuery()), fn (PendingRequest $r) => $r->withQueryParameters($request->getQuery()))
            ->when(count($request->getHeaders()), fn (PendingRequest $r) => $r->withHeaders($request->getHeaders()))
            ->when($this->token, fn (PendingRequest $r) => $r->withToken($this->token->getAccessToken())
                ->retry(config('esi.retry_policy.tries'), config('esi.retry_policy.delay'), fn (Exception $response) => ($response->response ?? false) && $request->shouldRetry($response->response), throw: false));

        $response = match ($request->getMethod()) {
            RequestMethod::GET => $pending_request->get($request->resolveEndpoint()),
            RequestMethod::POST => $pending_request->post($request->resolveEndpoint(), $request instanceof WithBody ? $request->getBody() : null),
            RequestMethod::PUT => $pending_request->put($request->resolveEndpoint(), $request instanceof WithBody ? $request->getBody() : null),
            RequestMethod::DELETE => $pending_request->delete($request->resolveEndpoint()),
            RequestMethod::PATCH => $pending_request->patch($request->resolveEndpoint()),
        };

        if ($response->failed()) {
            return new EsiResult(
                stats: $this->getStatsFromResponse($response),
                error: new EsiError(
                    code: $response->status(),
                    body: $response->body(),
                ),
            );
        }

        return new EsiResult(
            stats: $this->getStatsFromResponse($response),
            data: $request->createDtoFromResponse($response),
        );
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

    /**
     * @throws ConnectionException
     */
    public function sendPaginated(WithPagination $request): EsiResult
    {
        $page = 1;

        $results = [];

        do {
            $pending_request = Http::withHeaders([
                'User-Agent' => config('esi.user_agent'),
            ])
                ->baseUrl('https://esi.evetech.net/latest')
                ->when(count($request->getQuery()), fn (PendingRequest $r) => $r->withQueryParameters($request->getQuery()))
                ->withQueryParameters(['page' => $page])
                ->when(count($request->getHeaders()), fn (PendingRequest $r) => $r->withHeaders($request->getHeaders()))
                ->when($request instanceof WithBody, fn (PendingRequest $r) => $request instanceof WithBody ? $r->withBody($request->getBody()) : null)
                ->when($this->token, fn (PendingRequest $r) => $r->withToken($this->token->getAccessToken())
                    ->retry(config('esi.retry_policy.tries'), config('esi.retry_policy.delay'), fn (Exception $response) => ($response->response ?? false) && $request->shouldRetry($response->response), throw: false));

            $response = match ($request->getMethod()) {
                RequestMethod::GET => $pending_request->get($request->resolveEndpoint()),
                RequestMethod::POST => $pending_request->post($request->resolveEndpoint()),
                RequestMethod::PUT => $pending_request->put($request->resolveEndpoint()),
                RequestMethod::DELETE => $pending_request->delete($request->resolveEndpoint()),
                RequestMethod::PATCH => $pending_request->patch($request->resolveEndpoint()),
            };

            if ($response->failed()) {
                if (($response->forbidden() || $response->unauthorized()) && $this->token) {
                    $this->token->delete();
                }

                return new EsiResult(
                    stats: $this->getStatsFromResponse($response),
                    error: new EsiError(
                        code: $response->status(),
                        body: $response->body(),
                    ),
                );
            }

            $results = array_merge($results, $request->createDtoFromResponse($response));
            $page++;
        } while ($request->hasMorePages($page - 1, $response));

        return new EsiResult(
            stats: $this->getStatsFromResponse($response),
            data: $results,
        );
    }
}
