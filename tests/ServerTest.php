<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\RaidableSkyhook;
use NicolasKion\Esi\DTO\SkyhookTheftVulnerability;
use NicolasKion\Esi\DTO\Status;
use NicolasKion\Esi\Esi;

it('fetches and maps the server status', function (): void {
    Http::fake([
        'esi.evetech.net/status' => Http::response(esiFixture('status/status.json')),
    ]);

    $result = (new Esi)->getStatus();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Status::class)
        ->and($result->data->players)->toBe(42)
        ->and($result->data->server_version)->toBe('string')
        ->and($result->data->start_time)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->vip)->toBeTrue();
});

it('returns an error result when the status endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/status' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getStatus();

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('fetches and maps raidable skyhooks', function (): void {
    Http::fake([
        'esi.evetech.net/skyhooks/raidable*' => Http::response(esiFixture('skyhooks/raidable.json')),
    ]);

    $result = (new Esi)->getRaidableSkyhooks();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(RaidableSkyhook::class)
        ->and($result->data[0]->planet_id)->toBe(40000002)
        ->and($result->data[0]->solar_system_id)->toBe(30000001)
        ->and($result->data[0]->theft_vulnerability)->toBeInstanceOf(SkyhookTheftVulnerability::class)
        ->and($result->data[0]->theft_vulnerability->start)->toBe('2026-02-23T12:00:00Z')
        ->and($result->data[0]->theft_vulnerability->end)->toBe('2026-02-23T16:00:00Z');
});

it('returns an error result when the raidable skyhooks endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/skyhooks/raidable*' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getRaidableSkyhooks();

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('sets a waypoint with the destination and flags in the query', function (): void {
    Http::fake([
        'esi.evetech.net/ui/autopilot/waypoint*' => Http::response(null, 204),
    ]);

    $result = (new Esi)->setWaypoint(fakeCharacter(), 30000142, true, true);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/ui/autopilot/waypoint')
        && str_contains($request->url(), 'destination_id=30000142')
        && str_contains($request->url(), 'add_to_beginning=1')
        && str_contains($request->url(), 'clear_other_waypoints=1'));
});

it('returns an error result when setting a waypoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/ui/autopilot/waypoint*' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->setWaypoint(fakeCharacter(), 30000142);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
