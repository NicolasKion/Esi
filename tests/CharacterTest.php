<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\Character;
use NicolasKion\Esi\DTO\CharacterAffiliation;
use NicolasKion\Esi\DTO\Location;
use NicolasKion\Esi\DTO\Online;
use NicolasKion\Esi\DTO\Ship;
use NicolasKion\Esi\Esi;

it('fetches and maps a public character', function (): void {
    Http::fake([
        'esi.evetech.net/characters/90000001/' => Http::response(esiFixture('characters/detail.json')),
    ]);

    $result = (new Esi)->getCharacter(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Character::class)
        ->and($result->data->name)->toBe('string')
        ->and($result->data->corporation_id)->toBe(98777771)
        ->and($result->data->alliance_id)->toBe(99000001)
        ->and($result->data->birthday)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->gender)->toBe('male')
        ->and($result->data->bloodline_id)->toBe(1)
        ->and($result->data->race_id)->toBe(1)
        ->and($result->data->security_status)->toBe(5.0)
        // sourced from the `corporation_title` field (ESI renamed it from `title`)
        ->and($result->data->title)->toBe('string');
});

it('fetches character affiliations', function (): void {
    Http::fake([
        'esi.evetech.net/characters/affiliation/' => Http::response(esiFixture('characters/affiliation.json')),
    ]);

    $result = (new Esi)->getAffiliations([90000001]);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(CharacterAffiliation::class)
        ->and($result->data[0]->character_id)->toBe(90000001)
        ->and($result->data[0]->corporation_id)->toBe(90000001)
        ->and($result->data[0]->alliance_id)->toBe(90000001)
        ->and($result->data[0]->faction_id)->toBe(90000001);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/characters/affiliation/')
        && $request->data() === [90000001]);
});

it('fetches character location', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/location/' => Http::response(esiFixture('characters/location.json')),
    ]);

    $result = (new Esi)->getLocation(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Location::class)
        ->and($result->data->solar_system_id)->toBe(90000001)
        ->and($result->data->station_id)->toBe(90000001)
        ->and($result->data->structure_id)->toBe(90000001);
});

it('fetches character online status', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/online/' => Http::response(esiFixture('characters/online.json')),
    ]);

    $result = (new Esi)->getOnline(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Online::class)
        ->and($result->data->online)->toBeTrue()
        ->and($result->data->last_login)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->last_logout)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->logins)->toBe(90000001);
});

it('fetches character ship', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/ship/' => Http::response(esiFixture('characters/ship.json')),
    ]);

    $result = (new Esi)->getShip(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Ship::class)
        ->and($result->data->ship_type_id)->toBe(90000001)
        ->and($result->data->ship_item_id)->toBe(90000001)
        ->and($result->data->ship_name)->toBe('string');
});

it('returns an error result when the character endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/characters/90000001/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getCharacter(90000001);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
