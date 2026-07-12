<?php

declare(strict_types=1);

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\Esi;

it('walks cursor pages until the after cursor is empty', function (): void {
    Http::fakeSequence('esi.evetech.net/corporations/456/projects/*/contributors*')
        ->push(['cursor' => ['after' => 'CURSOR2'], 'contributors' => [['id' => 1, 'name' => 'A', 'contributed' => 10]]], 200)
        ->push(['cursor' => ['after' => ''], 'contributors' => [['id' => 2, 'name' => 'B', 'contributed' => 20]]], 200);

    $result = (new Esi)->getCorporationProjectContributors(fakeCharacter(), 456, 'project-uuid');

    // Both pages are merged into a single result set.
    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(2)
        ->and($result->data[0]->id)->toBe(1)
        ->and($result->data[1]->id)->toBe(2);

    // The second request forwards the `after` cursor returned by the first.
    Http::assertSent(fn ($request) => str_contains($request->url(), 'after=CURSOR2'));
});

it('stops after a single page when no after cursor is returned', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/projects/*/contributors*' => Http::response([
            'cursor' => [],
            'contributors' => [['id' => 7, 'name' => 'Solo', 'contributed' => 1]],
        ]),
    ]);

    $result = (new Esi)->getCorporationProjectContributors(fakeCharacter(), 456, 'project-uuid');

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1);

    Http::assertSentCount(1);
});

it('stops walking when the API keeps handing back the same cursor', function (): void {
    // A misbehaving endpoint that never advances its `after` cursor would loop
    // forever without the connector's non-advancing-cursor guard.
    Http::fake([
        'esi.evetech.net/corporations/456/projects/*/contributors*' => Http::response([
            'cursor' => ['after' => 'STUCK'],
            'contributors' => [['id' => 1, 'name' => 'A', 'contributed' => 10]],
        ]),
    ]);

    $result = (new Esi)->getCorporationProjectContributors(fakeCharacter(), 456, 'project-uuid');

    // The guard breaks the loop after re-encountering the `STUCK` cursor, so we
    // get the pages fetched before the repeat rather than an infinite loop.
    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(2);

    // Two distinct requests were made (initial + one `after=STUCK`) before the
    // guard recognised the repeated cursor and stopped.
    Http::assertSentCount(2);
});

it('returns a 500 error result when a cursor request throws a connection exception', function (): void {
    Http::fake([
        'esi.evetech.net/freelance-jobs*' => fn () => throw new ConnectionException('freelance-jobs unreachable'),
    ]);

    $result = (new Esi)->getFreelanceJobs();

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('short-circuits a cursor request when the connector already has an error', function (): void {
    config()->set('esi.client_id', 'client-id');
    config()->set('esi.client_secret', 'client-secret');

    $token = trackedToken(expired: true);

    Http::fake([
        'login.eveonline.com/*' => Http::response(['error' => 'invalid_grant'], 400),
    ]);

    $result = (new Esi)->getCorporationProjectContributors(characterFor($token), 456, 'project-uuid');

    expect($result->failed())->toBeTrue()
        ->and($token->deleted)->toBeTrue();
});
