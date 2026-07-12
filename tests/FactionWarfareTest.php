<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\CharacterFactionWarfareStats;
use NicolasKion\Esi\DTO\CorporationFactionWarfareStats;
use NicolasKion\Esi\DTO\FactionWarfareCharacterLeaderboard;
use NicolasKion\Esi\DTO\FactionWarfareCorporationLeaderboard;
use NicolasKion\Esi\DTO\FactionWarfareFactionStats;
use NicolasKion\Esi\DTO\FactionWarfareLeaderboard;
use NicolasKion\Esi\DTO\FactionWarfareSystem;
use NicolasKion\Esi\DTO\FactionWarfareWar;
use NicolasKion\Esi\Esi;

it('fetches and maps the faction leaderboards', function (): void {
    Http::fake([
        'esi.evetech.net/fw/leaderboards*' => Http::response(esiFixture('fw/leaderboards.json')),
    ]);

    $result = (new Esi)->getFactionWarfareLeaderboards();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(FactionWarfareLeaderboard::class)
        ->and($result->data->kills->active_total)->toHaveCount(1)
        ->and($result->data->kills->active_total[0]->amount)->toBe(90000001)
        ->and($result->data->kills->active_total[0]->faction_id)->toBe(90000001)
        ->and($result->data->kills->last_week[0]->amount)->toBe(90000001)
        ->and($result->data->kills->yesterday[0]->amount)->toBe(90000001)
        ->and($result->data->victory_points->active_total[0]->amount)->toBe(90000001)
        ->and($result->data->victory_points->last_week[0]->amount)->toBe(90000001)
        ->and($result->data->victory_points->yesterday[0]->amount)->toBe(90000001);
});

it('fetches and maps the character leaderboards', function (): void {
    Http::fake([
        'esi.evetech.net/fw/leaderboards/characters*' => Http::response(esiFixture('fw/character_leaderboards.json')),
    ]);

    $result = (new Esi)->getFactionWarfareCharacterLeaderboards();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(FactionWarfareCharacterLeaderboard::class)
        ->and($result->data->kills->active_total[0]->character_id)->toBe(90000001)
        ->and($result->data->kills->active_total[0]->amount)->toBe(90000001)
        ->and($result->data->kills->last_week[0]->character_id)->toBe(90000001)
        ->and($result->data->kills->yesterday[0]->character_id)->toBe(90000001)
        ->and($result->data->victory_points->active_total[0]->character_id)->toBe(90000001)
        ->and($result->data->victory_points->last_week[0]->character_id)->toBe(90000001)
        ->and($result->data->victory_points->yesterday[0]->character_id)->toBe(90000001);
});

it('fetches and maps the corporation leaderboards', function (): void {
    Http::fake([
        'esi.evetech.net/fw/leaderboards/corporations*' => Http::response(esiFixture('fw/corporation_leaderboards.json')),
    ]);

    $result = (new Esi)->getFactionWarfareCorporationLeaderboards();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(FactionWarfareCorporationLeaderboard::class)
        ->and($result->data->kills->active_total[0]->corporation_id)->toBe(90000001)
        ->and($result->data->kills->active_total[0]->amount)->toBe(90000001)
        ->and($result->data->kills->last_week[0]->corporation_id)->toBe(90000001)
        ->and($result->data->kills->yesterday[0]->corporation_id)->toBe(90000001)
        ->and($result->data->victory_points->active_total[0]->corporation_id)->toBe(90000001)
        ->and($result->data->victory_points->last_week[0]->corporation_id)->toBe(90000001)
        ->and($result->data->victory_points->yesterday[0]->corporation_id)->toBe(90000001);
});

it('fetches and maps the faction warfare stats', function (): void {
    Http::fake([
        'esi.evetech.net/fw/stats*' => Http::response(esiFixture('fw/stats.json')),
    ]);

    $result = (new Esi)->getFactionWarfareStats();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(FactionWarfareFactionStats::class)
        ->and($result->data[0]->faction_id)->toBe(90000001)
        ->and($result->data[0]->pilots)->toBe(90000001)
        ->and($result->data[0]->systems_controlled)->toBe(90000001)
        ->and($result->data[0]->kills->last_week)->toBe(90000001)
        ->and($result->data[0]->kills->total)->toBe(90000001)
        ->and($result->data[0]->kills->yesterday)->toBe(90000001)
        ->and($result->data[0]->victory_points->last_week)->toBe(90000001)
        ->and($result->data[0]->victory_points->total)->toBe(90000001)
        ->and($result->data[0]->victory_points->yesterday)->toBe(90000001);
});

it('fetches and maps the faction warfare systems', function (): void {
    Http::fake([
        'esi.evetech.net/fw/systems*' => Http::response(esiFixture('fw/systems.json')),
    ]);

    $result = (new Esi)->getFactionWarfareSystems();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(FactionWarfareSystem::class)
        ->and($result->data[0]->contested)->toBe('captured')
        ->and($result->data[0]->occupier_faction_id)->toBe(90000001)
        ->and($result->data[0]->owner_faction_id)->toBe(90000001)
        ->and($result->data[0]->solar_system_id)->toBe(90000001)
        ->and($result->data[0]->victory_points)->toBe(90000001)
        ->and($result->data[0]->victory_points_threshold)->toBe(90000001);
});

it('fetches and maps the faction warfare wars', function (): void {
    Http::fake([
        'esi.evetech.net/fw/wars*' => Http::response(esiFixture('fw/wars.json')),
    ]);

    $result = (new Esi)->getFactionWarfareWars();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(FactionWarfareWar::class)
        ->and($result->data[0]->against_id)->toBe(90000001)
        ->and($result->data[0]->faction_id)->toBe(90000001);
});

it('fetches and maps a character\'s faction warfare stats', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/fw/stats*' => Http::response(esiFixture('fw/character_stats.json')),
    ]);

    $result = (new Esi)->getCharacterFactionWarfareStats(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(CharacterFactionWarfareStats::class)
        ->and($result->data->current_rank)->toBe(90000001)
        ->and($result->data->enlisted_on)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->faction_id)->toBe(90000001)
        ->and($result->data->highest_rank)->toBe(90000001)
        ->and($result->data->kills->total)->toBe(90000001)
        ->and($result->data->victory_points->total)->toBe(90000001);
});

it('fetches and maps a corporation\'s faction warfare stats', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/fw/stats*' => Http::response(esiFixture('fw/corporation_stats.json')),
    ]);

    $result = (new Esi)->getCorporationFactionWarfareStats(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(CorporationFactionWarfareStats::class)
        ->and($result->data->enlisted_on)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->faction_id)->toBe(90000001)
        ->and($result->data->pilots)->toBe(90000001)
        ->and($result->data->kills->total)->toBe(90000001)
        ->and($result->data->victory_points->total)->toBe(90000001);
});

it('returns an error result when a faction warfare endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/fw/stats*' => Http::response('error', 500),
    ]);

    $result = (new Esi)->getFactionWarfareStats();

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
